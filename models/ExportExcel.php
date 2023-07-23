<?php
require_once './vendor/autoload.php';
setlocale(LC_ALL, 'id-ID', 'id_ID');


use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Font;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Shared\Date;


class ExportExcel
{
    private $spreadsheet;
    public function __construct()
    {
        $this->spreadsheet = new Spreadsheet();
    }
    public function addSheet($sheetName)
    {
        $sheetName = substr($sheetName, 0, 31);
        $Sheet = $this->spreadsheet->createSheet();
        $Sheet->setTitle($sheetName);
        $this->spreadsheet->setActiveSheetIndex($this->spreadsheet->getIndex(
            $this->spreadsheet->getSheetByName($sheetName)
        ));
        $this->spreadsheet->getActiveSheet()->getPageSetup()->setPaperSize(PageSetup::PAPERSIZE_A4);
        $this->spreadsheet->getActiveSheet()->getPageSetup()->setFitToPage(true);
        $this->spreadsheet->getActiveSheet()->getPageSetup()->setFitToWidth(1);
        $this->spreadsheet->getActiveSheet()->getPageSetup()->setFitToHeight(0);
        $this->spreadsheet->getActiveSheet()->getPageMargins()->setTop(1.9 / 2.54);
        $this->spreadsheet->getActiveSheet()->getPageMargins()->setRight(2 / 2.54);
        $this->spreadsheet->getActiveSheet()->getPageMargins()->setLeft(2.3 / 2.54);
        $this->spreadsheet->getActiveSheet()->getPageMargins()->setBottom(1.9 / 2.54);

        // Set the table to be in the middle of the page when printed
        $this->spreadsheet->getActiveSheet()->getPageSetup()->setHorizontalCentered(true);
    }
    public function setHeader($instance)
    {
        // $this->spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(2.86);
        $this->spreadsheet->getActiveSheet()->getRowDimension('1')->setRowHeight(21);
        $this->spreadsheet->getActiveSheet()->getRowDimension('3')->setRowHeight(21.75);
        $this->spreadsheet->getActiveSheet()->getRowDimension('4')->setRowHeight(18);
        $this->spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(8.43);
        $this->spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(12.29);
        $this->spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(12.14);
        $this->spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(9);
        $this->spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(10.71);
        $this->spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(9.57);
        $this->spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(12.14);
        $this->spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth(14);

        $this->spreadsheet->getActiveSheet()->mergeCells('B1:G1');

        // Add text to the merged cells
        $this->spreadsheet->getActiveSheet()->setCellValue('B1', 'REKAPAN TAGIHAN PERTASHOP 5P.611.16');

        // Center and style the text
        $this->spreadsheet->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);
        $this->spreadsheet->getActiveSheet()->getStyle('B1')->getFont()->setSize(16);
        $this->spreadsheet->getActiveSheet()->getStyle('B1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $this->spreadsheet->getActiveSheet()->getStyle('B1')->getAlignment()->setVertical(Alignment::VERTICAL_BOTTOM);

        $this->spreadsheet->getActiveSheet()->mergeCells('B2:G3');
        $this->spreadsheet->getActiveSheet()->setCellValue('B2', '=UPPER("' . $instance['keterangan'] . '")');
        $this->spreadsheet->getActiveSheet()->getStyle('B2')->getFont()->setBold(true);
        $this->spreadsheet->getActiveSheet()->getStyle('B2')->getFont()->setSize(12);
        $this->spreadsheet->getActiveSheet()->getStyle('B2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $this->spreadsheet->getActiveSheet()->getStyle('B2')->getAlignment()->setVertical(Alignment::VERTICAL_TOP);
        $this->spreadsheet->getActiveSheet()->getStyle('B2')->getAlignment()->setWrapText(true);
        // $this->spreadsheet->getActiveSheet()->setImageByPath('./assets/img/logo.png', 'B2', 15, 15, 20, 20);
        // $this->spreadsheet->getActiveSheet()->setImageByPath('./assets/img/logo-pertashop.png', 'I2', 15, 15, 20, 20);

        $drawing = new Drawing();
        $drawing->setName('Logo 1');
        $drawing->setDescription('Logo 1');
        $drawing->setPath('./assets/img/logo.png');
        $drawing->setCoordinates('A1');
        // $drawing->setWidth(1, 64 * (96 / 2.54));
        $drawing->setHeight(1.64 * (96 / 2.54));
        $drawing->setOffsetX(10);
        $drawing->setOffsetY(10);
        $drawing->setWorksheet($this->spreadsheet->getActiveSheet());

        $drawing = new Drawing();
        $drawing->setName('Logo 2');
        $drawing->setDescription('Logo 2');
        $drawing->setPath('./assets/img/logo-pertashop.png');
        $drawing->setCoordinates('H1');
        // $drawing->setWidth(1, 64 * (96 / 2.54));
        $drawing->setHeight(1.64 * (96 / 2.54));
        $drawing->setOffsetX(18);
        $drawing->setOffsetY(10);
        $drawing->setWorksheet($this->spreadsheet->getActiveSheet());

        $this->spreadsheet->getActiveSheet()->getStyle('A1:H4')->applyFromArray([
            'borders' => [
                'top' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
                'left' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
                'right' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
            ],
        ]);
    }
    public function generateTable($data)
    {
        $nextRow = $this->spreadsheet->getActiveSheet()->getHighestRow() + 1;
        $topRow = $nextRow;
        $this->spreadsheet->getActiveSheet()->setCellValue('A' . $nextRow, 'No');
        $this->spreadsheet->getActiveSheet()->setCellValue('B' . $nextRow, 'Tanggal');
        $this->spreadsheet->getActiveSheet()->setCellValue('C' . $nextRow, 'Nama Produk');
        $this->spreadsheet->getActiveSheet()->setCellValue('D' . $nextRow, 'Nota');
        $this->spreadsheet->getActiveSheet()->setCellValue('E' . $nextRow, 'NOPOL');
        $this->spreadsheet->getActiveSheet()->setCellValue('F' . $nextRow, 'Qty');
        $this->spreadsheet->getActiveSheet()->setCellValue('G' . $nextRow, 'Harga');
        $this->spreadsheet->getActiveSheet()->setCellValue('H' . $nextRow, 'Jumlah');
        $this->spreadsheet->getActiveSheet()->setCellValue('J' . $nextRow, 'Keterangan');
        $this->spreadsheet->getActiveSheet()->setCellValue('K' . $nextRow, 'Petugas');

        $this->spreadsheet->getActiveSheet()->getStyle('A' . $nextRow . ':H' . $nextRow)->getFont()->setBold(true);
        $this->spreadsheet->getActiveSheet()->getStyle('A' . $nextRow . ':H' . $nextRow)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('B4C6E7');
        $this->spreadsheet->getActiveSheet()->getStyle('A' . $nextRow . ':H' . $nextRow)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_MEDIUM,
                ],
            ],
        ]);
        $nextRow++;



        $number = 0;
        $tgl = 0;
        $curNumber = 0;


        foreach ($data['transactions'] as $transaction) {

            $checkTimestamp = (new DateTime($transaction['timestamp']))->format('d/m/Y');
            $timestamp = Date::PHPToExcel($transaction['timestamp']);
            if ($checkTimestamp != $tgl) {
                $curNumber = ++$number;
                $tgl = $checkTimestamp;
            } else {
                $curNumber = '';
                $timestamp = '';
            }

            $this->spreadsheet->getActiveSheet()->setCellValue('A' . $nextRow, $curNumber);

            // format timestamp 
            $this->spreadsheet->getActiveSheet()->setCellValue('B' . $nextRow, $timestamp);

            $this->spreadsheet->getActiveSheet()->setCellValue('C' . $nextRow, $transaction['jenis_bbm']);
            $this->spreadsheet->getActiveSheet()->setCellValue('D' . $nextRow, $transaction['nota']);
            $this->spreadsheet->getActiveSheet()->setCellValue('E' . $nextRow, $transaction['plat_nomor']);
            $this->spreadsheet->getActiveSheet()->setCellValue('F' . $nextRow, $transaction['qty']);
            $this->spreadsheet->getActiveSheet()->setCellValue('G' . $nextRow, $transaction['harga']);
            $this->spreadsheet->getActiveSheet()->setCellValue('H' . $nextRow, $transaction['total']);
            $this->spreadsheet->getActiveSheet()->setCellValue('J' . $nextRow, $transaction['keterangan']);
            $this->spreadsheet->getActiveSheet()->setCellValue('K' . $nextRow, $transaction['petugas']);
            $nextRow++;
        }

        //Format the qty column with two decimal places
        $this->spreadsheet->getActiveSheet()->getStyle('F' . $topRow + 1 . ':F' . $nextRow - 1)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_00);
        $this->spreadsheet->getActiveSheet()->getStyle('B' . $topRow + 1 . ':B' . $nextRow - 1)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);

        //Format the price and total pay columns as IDR currency
        $this->spreadsheet->getActiveSheet()->getStyle('G' . $topRow + 1 . ':H' . $nextRow - 1)->getNumberFormat()->setFormatCode('_-Rp* #,##0_-;-Rp* #,##0_-;_-Rp* "-"??_-;_-@_-');
        $this->spreadsheet->getActiveSheet()->getStyle('A' . $topRow . ':H' . $nextRow - 1)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_MEDIUM,
                ],
                'horizontal' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
            ],
        ];
        $this->spreadsheet->getActiveSheet()->getStyle('A' . $topRow + 1 . ':H' . $nextRow - 1)->applyFromArray($styleArray);

        // Set the cell to write the SUM formula
        $this->spreadsheet->getActiveSheet()->setCellValue('G' . $nextRow, 'Total');
        $this->spreadsheet->getActiveSheet()->setCellValue('H' . $nextRow, '=SUM(H' . $topRow + 1 . ':H' . $nextRow - 1 . ')');
        $this->spreadsheet->getActiveSheet()->getStyle('H' . $nextRow)->getNumberFormat()->setFormatCode('_-Rp* #,##0_-;-Rp* #,##0_-;_-Rp* "-"??_-;_-@_-');
        $this->spreadsheet->getActiveSheet()->getStyle('G' . $nextRow . ':H' . $nextRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $this->spreadsheet->getActiveSheet()->getStyle('G' . $nextRow . ':H' . $nextRow)->getFont()->setBold(true);
        $this->spreadsheet->getActiveSheet()->getStyle('G' . $nextRow . ':H' . $nextRow)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('B4C6E7');
        $this->spreadsheet->getActiveSheet()->getStyle('G' . $nextRow . ':H' . $nextRow)->applyFromArray($styleArray);
    }
    public function setPeriod()
    {
        $nextRow = $this->spreadsheet->getActiveSheet()->getHighestRow();

        $this->spreadsheet->getActiveSheet()->mergeCells('A4:C4');

        $this->spreadsheet->getActiveSheet()->setCellValue(
            'A4',
            '="Periode : "&TEXT(MIN(B6:B' . $nextRow - 1 . '),"dd")&"-"&TEXT(MAX(B6:B' . $nextRow - 1 . '),"dd mmmm yyy")'
        );

        $this->spreadsheet->getActiveSheet()->getStyle('A4')->getFont()->setBold(true);
        $this->spreadsheet->getActiveSheet()->getStyle('A4')->getFont()->setSize(12);
        $this->spreadsheet->getActiveSheet()->getStyle('A4')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
    }
    public function setFooter($data)
    {
        $ttdRow = $this->spreadsheet->getActiveSheet()->getHighestRow() + 2;
        $this->spreadsheet->getActiveSheet()->setCellValue('A' . $ttdRow++, 'Gresik, ' . strftime("%d %B %Y"));
        $this->spreadsheet->getActiveSheet()->setCellValue('A' . $ttdRow, $data['TTD']['ket']);
        $this->spreadsheet->getActiveSheet()->setCellValue('D' . $ttdRow, $data['TTD2']['ket']);
        $this->spreadsheet->getActiveSheet()->setCellValue('G' . $ttdRow, $data['TTD3']['ket']);
        $ttdRow += 5;
        $this->spreadsheet->getActiveSheet()->setCellValue('A' . $ttdRow, $data['TTD']['nama']);
        $this->spreadsheet->getActiveSheet()->getStyle('A' . $ttdRow)->getFont()->setBold(true);
        $this->spreadsheet->getActiveSheet()->getStyle('A' . $ttdRow)->getFont()->setUnderline(true);
        $this->spreadsheet->getActiveSheet()->setCellValue('A' . $ttdRow + 1, $data['TTD']['jabatan']);

        $this->spreadsheet->getActiveSheet()->setCellValue('D' . $ttdRow, $data['TTD2']['nama']);
        $this->spreadsheet->getActiveSheet()->getStyle('D' . $ttdRow)->getFont()->setBold(true);
        $this->spreadsheet->getActiveSheet()->getStyle('D' . $ttdRow)->getFont()->setUnderline(true);
        $this->spreadsheet->getActiveSheet()->setCellValue('D' . $ttdRow + 1, $data['TTD2']['jabatan']);

        $this->spreadsheet->getActiveSheet()->setCellValue('G' . $ttdRow, $data['TTD3']['nama']);
        $this->spreadsheet->getActiveSheet()->getStyle('G' . $ttdRow)->getFont()->setBold(true);
        $this->spreadsheet->getActiveSheet()->getStyle('G' . $ttdRow)->getFont()->setUnderline(true);
        $this->spreadsheet->getActiveSheet()->setCellValue('G' . $ttdRow + 1, $data['TTD3']['jabatan']);
        // $this->spreadsheet->getActiveSheet()->setBreak('A' . $ttdRow, Worksheet::BREAK_ROW);
    }
    public function download($filename)
    {
        $this->spreadsheet->removeSheetByIndex($this->spreadsheet->getIndex($this->spreadsheet->getSheetByName('Worksheet')));

        $this->spreadsheet->setActiveSheetIndex(0);

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');
        $writer = new Xlsx($this->spreadsheet);
        $writer->save('php://output');
    }
    public function save($filename)
    {
        $this->spreadsheet->removeSheetByIndex($this->spreadsheet->getIndex($this->spreadsheet->getSheetByName('Worksheet')));
        $writer = new Xlsx($this->spreadsheet);
        $writer->save('./assets/export/' . $filename . '.xlsx');
        return [
            $filename . '.xlsx',
            BASEURL . '/assets/export/' . $filename . '.xlsx'
        ];
    }
    public function removeSaved($path)
    {
        unlink($path);
    }
    public function generateSalesTable($data)
    {

        $this->spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(8.43);
        $this->spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(12.29);
        $this->spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(53.14);
        $this->spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(12.14);
        $this->spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(9);
        $this->spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(10.71);
        $this->spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(9.57);
        $this->spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth(12.14);
        $this->spreadsheet->getActiveSheet()->getColumnDimension('I')->setWidth(14);

        $nextRow = $this->spreadsheet->getActiveSheet()->getHighestRow();
        $topRow = $nextRow;
        $this->spreadsheet->getActiveSheet()->setCellValue('A' . $nextRow, 'No');
        $this->spreadsheet->getActiveSheet()->setCellValue('B' . $nextRow, 'Tanggal');
        $this->spreadsheet->getActiveSheet()->setCellValue('C' . $nextRow, 'Instansi');
        $this->spreadsheet->getActiveSheet()->setCellValue('D' . $nextRow, 'Nama Produk');
        $this->spreadsheet->getActiveSheet()->setCellValue('E' . $nextRow, 'Nota');
        $this->spreadsheet->getActiveSheet()->setCellValue('F' . $nextRow, 'NOPOL');
        $this->spreadsheet->getActiveSheet()->setCellValue('G' . $nextRow, 'Qty');
        $this->spreadsheet->getActiveSheet()->setCellValue('H' . $nextRow, 'Harga');
        $this->spreadsheet->getActiveSheet()->setCellValue('I' . $nextRow, 'Jumlah');

        $this->spreadsheet->getActiveSheet()->getStyle('A' . $nextRow . ':I' . $nextRow)->getFont()->setBold(true);
        $this->spreadsheet->getActiveSheet()->getStyle('A' . $nextRow . ':I' . $nextRow)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('B4C6E7');
        $this->spreadsheet->getActiveSheet()->getStyle('A' . $nextRow . ':I' . $nextRow)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_MEDIUM,
                ],
            ],
        ]);
        $nextRow++;



        $number = 0;
        $tgl = 0;
        $curNumber = 0;


        foreach ($data['transactions'] as $transaction) {

            $checkTimestamp = (new DateTime($transaction['timestamp']))->format('d/m/Y');
            $timestamp = Date::PHPToExcel($transaction['timestamp']);
            if ($checkTimestamp != $tgl) {
                $curNumber = ++$number;
                $tgl = $checkTimestamp;
            } else {
                $curNumber = '';
                $timestamp = '';
            }

            $this->spreadsheet->getActiveSheet()->setCellValue('A' . $nextRow, $curNumber);

            // format timestamp 
            $this->spreadsheet->getActiveSheet()->setCellValue('B' . $nextRow, $timestamp);

            $this->spreadsheet->getActiveSheet()->setCellValue('C' . $nextRow, $transaction['instansi']);
            $this->spreadsheet->getActiveSheet()->setCellValue('D' . $nextRow, $transaction['jenis_bbm']);
            $this->spreadsheet->getActiveSheet()->setCellValue('E' . $nextRow, $transaction['nota']);
            $this->spreadsheet->getActiveSheet()->setCellValue('F' . $nextRow, $transaction['plat_nomor']);
            $this->spreadsheet->getActiveSheet()->setCellValue('G' . $nextRow, $transaction['qty']);
            $this->spreadsheet->getActiveSheet()->setCellValue('H' . $nextRow, $transaction['harga']);
            $this->spreadsheet->getActiveSheet()->setCellValue('I' . $nextRow, $transaction['total']);
            $nextRow++;
        }

        //Format the qty column with two decimal places
        $this->spreadsheet->getActiveSheet()->getStyle('G' . $topRow + 1 . ':G' . $nextRow - 1)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_00);
        $this->spreadsheet->getActiveSheet()->getStyle('B' . $topRow + 1 . ':B' . $nextRow - 1)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);

        //Format the price and total pay columns as IDR currency
        $this->spreadsheet->getActiveSheet()->getStyle('H' . $topRow + 1 . ':I' . $nextRow - 1)->getNumberFormat()->setFormatCode('_-Rp* #,##0_-;-Rp* #,##0_-;_-Rp* "-"??_-;_-@_-');
        $this->spreadsheet->getActiveSheet()->getStyle('A' . $topRow . ':I' . $nextRow - 1)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_MEDIUM,
                ],
                'horizontal' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
            ],
        ];
        $this->spreadsheet->getActiveSheet()->getStyle('A' . $topRow + 1 . ':I' . $nextRow - 1)->applyFromArray($styleArray);

        // Set the cell to write the SUM formula
        $this->spreadsheet->getActiveSheet()->setCellValue('H' . $nextRow, 'Total');
        $this->spreadsheet->getActiveSheet()->setCellValue('I' . $nextRow, '=SUM(I' . $topRow + 1 . ':I' . $nextRow - 1 . ')');
        $this->spreadsheet->getActiveSheet()->getStyle('I' . $nextRow)->getNumberFormat()->setFormatCode('_-Rp* #,##0_-;-Rp* #,##0_-;_-Rp* "-"??_-;_-@_-');
        $this->spreadsheet->getActiveSheet()->getStyle('H' . $nextRow . ':I' . $nextRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $this->spreadsheet->getActiveSheet()->getStyle('H' . $nextRow . ':I' . $nextRow)->getFont()->setBold(true);
        $this->spreadsheet->getActiveSheet()->getStyle('H' . $nextRow . ':I' . $nextRow)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('B4C6E7');
        $this->spreadsheet->getActiveSheet()->getStyle('H' . $nextRow . ':I' . $nextRow)->applyFromArray($styleArray);
    }
    public function generateStockTransactionHistory($data)
    {

        $nextRow = $this->spreadsheet->getActiveSheet()->getHighestRow();
        $topRow = $nextRow;
        $this->spreadsheet->getActiveSheet()->setCellValue('A' . $nextRow, 'No');
        $this->spreadsheet->getActiveSheet()->setCellValue('B' . $nextRow, 'Tanggal');
        $this->spreadsheet->getActiveSheet()->setCellValue('C' . $nextRow, 'Nama Produk');
        $this->spreadsheet->getActiveSheet()->setCellValue('D' . $nextRow, 'Nota');
        $this->spreadsheet->getActiveSheet()->setCellValue('E' . $nextRow, 'NOPOL');
        $this->spreadsheet->getActiveSheet()->setCellValue('F' . $nextRow, 'Qty');
        $this->spreadsheet->getActiveSheet()->setCellValue('G' . $nextRow, 'Harga');
        $this->spreadsheet->getActiveSheet()->setCellValue('H' . $nextRow, 'Jumlah');
        $this->spreadsheet->getActiveSheet()->setCellValue('I' . $nextRow, 'Instansi');

        $this->spreadsheet->getActiveSheet()->getStyle('A' . $nextRow . ':I' . $nextRow)->getFont()->setBold(true);
        $this->spreadsheet->getActiveSheet()->getStyle('A' . $nextRow . ':I' . $nextRow)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('B4C6E7');
        $this->spreadsheet->getActiveSheet()->getStyle('A' . $nextRow . ':I' . $nextRow)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_MEDIUM,
                ],
            ],
        ]);
        $nextRow++;
        $curNumber = 1;


        foreach ($data['transactions'] as $transaction) {

            $timestamp = Date::PHPToExcel($transaction['timestamp']);
            $this->spreadsheet->getActiveSheet()->setCellValue('A' . $nextRow, $curNumber++);

            // format timestamp 
            $this->spreadsheet->getActiveSheet()->setCellValue('B' . $nextRow, $timestamp);

            $this->spreadsheet->getActiveSheet()->setCellValue('C' . $nextRow, $transaction['jenis_bbm']);
            $this->spreadsheet->getActiveSheet()->setCellValue('D' . $nextRow, $transaction['nota']);
            $this->spreadsheet->getActiveSheet()->setCellValue('E' . $nextRow, $transaction['plat_nomor']);
            $this->spreadsheet->getActiveSheet()->setCellValue('F' . $nextRow, $transaction['qty']);
            $this->spreadsheet->getActiveSheet()->setCellValue('G' . $nextRow, $transaction['harga']);
            $this->spreadsheet->getActiveSheet()->setCellValue('H' . $nextRow, $transaction['total']);
            $this->spreadsheet->getActiveSheet()->setCellValue('I' . $nextRow, $transaction['instansi']);
            $nextRow++;
        }

        //Format the qty column with two decimal places
        $this->spreadsheet->getActiveSheet()->getStyle('F' . $topRow + 1 . ':F' . $nextRow - 1)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_00);
        $this->spreadsheet->getActiveSheet()->getStyle('B' . $topRow + 1 . ':B' . $nextRow - 1)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);

        //Format the price and total pay columns as IDR currency
        $this->spreadsheet->getActiveSheet()->getStyle('G' . $topRow + 1 . ':H' . $nextRow - 1)->getNumberFormat()->setFormatCode('_-Rp* #,##0_-;-Rp* #,##0_-;_-Rp* "-"??_-;_-@_-');
        $this->spreadsheet->getActiveSheet()->getStyle('A' . $topRow . ':I' . $nextRow - 1)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_MEDIUM,
                ],
                'horizontal' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
            ],
        ];
        $this->spreadsheet->getActiveSheet()->getStyle('A' . $topRow + 1 . ':I' . $nextRow - 1)->applyFromArray($styleArray);

        $this->spreadsheet->getActiveSheet()->setCellValue('F' . $nextRow, '=SUM(F2:F' . $nextRow - 1 . ')');
        $this->spreadsheet->getActiveSheet()->setCellValue('H' . $nextRow, '=SUM(H2:H' . $nextRow - 1 . ')');
        $this->spreadsheet->getActiveSheet()->getStyle('H' . $nextRow)->getNumberFormat()->setFormatCode('_-Rp* #,##0_-;-Rp* #,##0_-;_-Rp* "-"??_-;_-@_-');
        $this->spreadsheet->getActiveSheet()->getStyle('F' . $nextRow)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_00);
        $this->spreadsheet->getActiveSheet()->getStyle('F' . $nextRow . ':H' . $nextRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $this->spreadsheet->getActiveSheet()->getStyle('F' . $nextRow . ':H' . $nextRow)->getFont()->setBold(true);
        $this->spreadsheet->getActiveSheet()->getStyle('F' . $nextRow . ':H' . $nextRow)->applyFromArray($styleArray);
    }
    public function generateRecapTable($fuelType, $month, $data)
    {
        $this->spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(2.86);
        $this->spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(11.57);
        $this->spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(18.43);
        $this->spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(0);
        $this->spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(12.29);
        $this->spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(12.57);
        $this->spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(17.14);
        $this->spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth(0);
        $this->spreadsheet->getActiveSheet()->getColumnDimension('I')->setWidth(12.29);
        $this->spreadsheet->getActiveSheet()->getColumnDimension('J')->setWidth(12.57);
        $this->spreadsheet->getActiveSheet()->getColumnDimension('K')->setWidth(17.14);
        $this->spreadsheet->getActiveSheet()->getColumnDimension('L')->setWidth(12.29);
        $this->spreadsheet->getActiveSheet()->getColumnDimension('M')->setWidth(12.57);
        $this->spreadsheet->getActiveSheet()->getColumnDimension('N')->setWidth(17.14);

        $nextRow = $this->spreadsheet->getActiveSheet()->getHighestRow() + 1;
        $topHeaderRow = $nextRow;

        $this->spreadsheet->getActiveSheet()->mergeCells('B' . $nextRow . ':N' . $nextRow);
        $this->spreadsheet->getActiveSheet()->setCellValue('B' . $nextRow, 'STOK PERSEDIAAN ' . strtoupper($fuelType) . ' 5P.611.16');
        $nextRow++;

        setlocale(LC_ALL, 'id-ID', 'id_ID');
        $month =  strftime("%B %Y", strtotime($month));
        $this->spreadsheet->getActiveSheet()->mergeCells('B' . $nextRow . ':N' . $nextRow);
        $this->spreadsheet->getActiveSheet()->setCellValue('B' . $nextRow, strtoupper($month));

        $this->spreadsheet->getActiveSheet()->getStyle('B' . $topHeaderRow . ':B' . $nextRow)->getFont()->setBold(true);
        $this->spreadsheet->getActiveSheet()->getStyle('B' . $topHeaderRow . ':B' . $nextRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $this->spreadsheet->getActiveSheet()->getStyle('B' . $topHeaderRow . ':B' . $nextRow)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        $nextRow++;

        $this->spreadsheet->getActiveSheet()->mergeCells('B' . $nextRow . ':N' . $nextRow);
        $this->spreadsheet->getActiveSheet()->setCellValue('B' . $nextRow, 'Metode : FIFO');
        $this->spreadsheet->getActiveSheet()->getStyle('B' . $nextRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
        $this->spreadsheet->getActiveSheet()->getStyle('B' . $nextRow)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $nextRow = $this->spreadsheet->getActiveSheet()->getHighestRow() + 1;
        $topTableHeaderRow = $nextRow++;

        $this->spreadsheet->getActiveSheet()->mergeCells('B' . $topTableHeaderRow . ':B' . $nextRow);
        $this->spreadsheet->getActiveSheet()->setCellValue('B' . $topTableHeaderRow, 'TANGGAL');

        $this->spreadsheet->getActiveSheet()->mergeCells('C' . $topTableHeaderRow . ':C' . $nextRow);
        $this->spreadsheet->getActiveSheet()->setCellValue('C' . $topTableHeaderRow, 'KETERANGAN');

        $this->spreadsheet->getActiveSheet()->mergeCells('D' . $topTableHeaderRow . ':G' . $topTableHeaderRow);
        $this->spreadsheet->getActiveSheet()->setCellValue('D' . $topTableHeaderRow, 'PEMBELIAN');
        $this->spreadsheet->getActiveSheet()->setCellValue('D' . $nextRow, 'ID STOK');
        $this->spreadsheet->getActiveSheet()->setCellValue('E' . $nextRow, 'QTY');
        $this->spreadsheet->getActiveSheet()->setCellValue('F' . $nextRow, 'HARGA');
        $this->spreadsheet->getActiveSheet()->setCellValue('G' . $nextRow, 'JUMLAH');

        $this->spreadsheet->getActiveSheet()->mergeCells('H' . $topTableHeaderRow . ':K' . $topTableHeaderRow);
        $this->spreadsheet->getActiveSheet()->setCellValue('H' . $topTableHeaderRow, 'PENJUALAN');
        $this->spreadsheet->getActiveSheet()->setCellValue('H' . $nextRow, 'ID STOK');
        $this->spreadsheet->getActiveSheet()->setCellValue('I' . $nextRow, 'QTY');
        $this->spreadsheet->getActiveSheet()->setCellValue('J' . $nextRow, 'HARGA');
        $this->spreadsheet->getActiveSheet()->setCellValue('K' . $nextRow, 'JUMLAH');

        $this->spreadsheet->getActiveSheet()->mergeCells('L' . $topTableHeaderRow . ':N' . $topTableHeaderRow);
        $this->spreadsheet->getActiveSheet()->setCellValue('L' . $topTableHeaderRow, 'PERSEDIAAN AKHIR');
        $this->spreadsheet->getActiveSheet()->setCellValue('L' . $nextRow, 'QTY');
        $this->spreadsheet->getActiveSheet()->setCellValue('M' . $nextRow, 'HARGA');
        $this->spreadsheet->getActiveSheet()->setCellValue('N' . $nextRow, 'JUMLAH');
        $this->spreadsheet->getActiveSheet()->setCellValue('V' . $nextRow, 'QTY BY APP');
        $this->spreadsheet->getActiveSheet()->setCellValue('W' . $nextRow, 'JUMLAH BY APP');
        $this->spreadsheet->getActiveSheet()->mergeCells('X' . $nextRow . ':Y' . $nextRow);
        $this->spreadsheet->getActiveSheet()->setCellValue('X' . $nextRow, 'SELISIH');

        $this->spreadsheet->getActiveSheet()->getStyle('B' . $topTableHeaderRow . ':N' . $nextRow)->getFont()->setBold(true);
        $this->spreadsheet->getActiveSheet()->getStyle('B' . $topTableHeaderRow . ':N' . $nextRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $this->spreadsheet->getActiveSheet()->getStyle('B' . $topTableHeaderRow . ':N' . $nextRow)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        $this->spreadsheet->getActiveSheet()->getStyle('B' . $topTableHeaderRow . ':N' . $nextRow)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
            ],
        ]);

        $nextRow = $this->spreadsheet->getActiveSheet()->getHighestRow() + 1;
        $topRow = $nextRow;
        $penjualan = [];
        $no = 0;
        foreach ($data as $stick) {

            ++$no;
            $timestamp = Date::PHPToExcel($stick['tgl']);
            $this->spreadsheet->getActiveSheet()->setCellValue('B' . $nextRow, $timestamp);
            $this->spreadsheet->getActiveSheet()->setCellValue('C' . $nextRow, $stick['ket']);
            if ($stick['ket'] == 'Persediaan Awal' || strpos(strtolower($stick['ket']), 'pembelian') === 0) {
                $this->spreadsheet->getActiveSheet()->getStyle('C' . $nextRow)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('B4C6E7');
            } elseif (strpos(strtolower($stick['ket']), 'penjualan') === 0) {
            } else {
                $this->spreadsheet->getActiveSheet()->getStyle('C' . $nextRow)->getFont()->setColor(new Color(Color::COLOR_RED));
            }
            if ($stick['ket'] != 'Persediaan Awal') {
                $this->spreadsheet->getActiveSheet()->setCellValue('D' . $nextRow, $stick['id_stok_pembelian']);
                $this->spreadsheet->getActiveSheet()->setCellValue('E' . $nextRow, $stick['qty_pembelian']);
                $this->spreadsheet->getActiveSheet()->setCellValue('F' . $nextRow, $stick['harga_pembelian']);
                $this->spreadsheet->getActiveSheet()->setCellValue('G' . $nextRow, '=E' . $nextRow . '*F' . $nextRow);
                // $this->spreadsheet->getActiveSheet()->setCellValue('G' . $nextRow, $stick['jumlah_pembelian']);


                $this->spreadsheet->getActiveSheet()->setCellValue('H' . $nextRow, $stick['id_stok_penjualan']);
                $this->spreadsheet->getActiveSheet()->setCellValue('I' . $nextRow, $stick['qty_penjualan']);
                $this->spreadsheet->getActiveSheet()->setCellValue('J' . $nextRow, $stick['harga_penjualan']);
                $this->spreadsheet->getActiveSheet()->setCellValue('K' . $nextRow, '=I' . $nextRow . '*J' . $nextRow);
            }
            // $this->spreadsheet->getActiveSheet()->setCellValue('K' . $nextRow, $stick['jumlah_penjualan']);
            if (!empty($stick['id_stok_penjualan']) && strpos(strtolower($stick['ket']), 'penjualan') === 0) {
                if (empty($penjualan[$stick['id_stok_penjualan']])) {
                    $penjualan[$stick['id_stok_penjualan']] = [
                        $stick['id_stok_penjualan'],
                        $stick['qty_penjualan'],
                        $stick['harga_penjualan'],
                        $stick['jumlah_penjualan']
                    ];
                } else {
                    $penjualan[$stick['id_stok_penjualan']][1] += $stick['qty_penjualan'];
                    $penjualan[$stick['id_stok_penjualan']][3] += $stick['jumlah_penjualan'];
                }
            }
            if ($stick['ket'] == 'Persediaan Awal' || $no == 1) {
                $this->spreadsheet->getActiveSheet()->setCellValue('L' . $nextRow, $stick['qty_persediaan']);
                $this->spreadsheet->getActiveSheet()->setCellValue('N' . $nextRow, $stick['jumlah_persediaan']);
            } else {
                $this->spreadsheet->getActiveSheet()->setCellValue('L' . $nextRow, '=L' . $nextRow - 1 . '+E' . $nextRow . '-I' . $nextRow);
                $this->spreadsheet->getActiveSheet()->setCellValue('N' . $nextRow, '=N' . $nextRow - 1 . '+G' . $nextRow . '-K' . $nextRow);
            }
            $this->spreadsheet->getActiveSheet()->setCellValue('V' . $nextRow, $stick['qty_persediaan']);
            $this->spreadsheet->getActiveSheet()->setCellValue('W' . $nextRow, $stick['jumlah_persediaan']);
            $this->spreadsheet->getActiveSheet()->setCellValue('X' . $nextRow, "=V$nextRow-L$nextRow");
            $this->spreadsheet->getActiveSheet()->setCellValue('Y' . $nextRow, "=W$nextRow-N$nextRow");
            // $this->spreadsheet->getActiveSheet()->setCellValue('L' . $nextRow, $stick['qty_persediaan']);
            // $this->spreadsheet->getActiveSheet()->setCellValue('N' . $nextRow, $stick['jumlah_persediaan']);
            $nextRow++;
        }
        $endRow = $nextRow - 1;
        $sumRow = $nextRow;
        $this->spreadsheet->getActiveSheet()->mergeCells('B' . $nextRow . ':C' . $nextRow);
        $this->spreadsheet->getActiveSheet()->setCellValue('B' . $nextRow, 'JUMLAH');
        $this->spreadsheet->getActiveSheet()->getStyle('B' . $nextRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);


        $this->spreadsheet->getActiveSheet()->setCellValue('E' . $nextRow, '=SUM(E' . $topRow . ':E' . $endRow . ')');
        $this->spreadsheet->getActiveSheet()->setCellValue('G' . $nextRow, '=SUM(G' . $topRow . ':G' . $endRow . ')');
        $this->spreadsheet->getActiveSheet()->setCellValue('I' . $nextRow, '=SUM(I' . $topRow . ':I' . $endRow . ')');
        $this->spreadsheet->getActiveSheet()->setCellValue('K' . $nextRow, '=SUM(K' . $topRow . ':K' . $endRow . ')');
        $this->spreadsheet->getActiveSheet()->getStyle('B' . $nextRow . ':N' . $nextRow)->getFont()->setBold(true);

        $this->spreadsheet->getActiveSheet()->getStyle('B' . $topRow . ':B' . $nextRow)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);

        $this->spreadsheet->getActiveSheet()->getStyle('E' . $topRow . ':E' . $nextRow)->getNumberFormat()->setFormatCode('* #,##0.00 "L";* -#,##0.00 "L";* "-"??_-;_-@_-');
        $this->spreadsheet->getActiveSheet()->getStyle('I' . $topRow . ':I' . $nextRow)->getNumberFormat()->setFormatCode('* #,##0.00 "L";* -#,##0.00 "L";* "-"??_-;_-@_-');
        $this->spreadsheet->getActiveSheet()->getStyle('L' . $topRow . ':L' . $nextRow)->getNumberFormat()->setFormatCode('* #,##0.00 "L";* -#,##0.00 "L";* "-"??_-;_-@_-');
        $this->spreadsheet->getActiveSheet()->getStyle('V' . $topRow . ':V' . $nextRow)->getNumberFormat()->setFormatCode('* #,##0.00 "L";* -#,##0.00 "L";* "-"??_-;_-@_-');
        $this->spreadsheet->getActiveSheet()->getStyle('X' . $topRow . ':X' . $nextRow)->getNumberFormat()->setFormatCode('* #,##0.00 "L";* -#,##0.00 "L";* "-"??_-;_-@_-');
        // $this->spreadsheet->getActiveSheet()->getStyle('E' . $topRow . ':E' . $nextRow)->getNumberFormat()->setFormatCode('_-* #,##0.00_-;-* #,##0.00_-;_-* "-"??_-;_-@_-');
        // $this->spreadsheet->getActiveSheet()->getStyle('I' . $topRow . ':I' . $nextRow)->getNumberFormat()->setFormatCode('_-* #,##0.00_-;-* #,##0.00_-;_-* "-"??_-;_-@_-');
        // $this->spreadsheet->getActiveSheet()->getStyle('L' . $topRow . ':L' . $nextRow)->getNumberFormat()->setFormatCode('_-* #,##0.00_-;-* #,##0.00_-;_-* "-"??_-;_-@_-');

        //Format the price and total pay columns as IDR currency
        $this->spreadsheet->getActiveSheet()->getStyle('F' . $topRow . ':G' . $nextRow)->getNumberFormat()->setFormatCode('_-Rp* #,##0_-;-Rp* #,##0_-;_-* "-"??_-;_-@_-');
        $this->spreadsheet->getActiveSheet()->getStyle('J' . $topRow . ':K' . $nextRow)->getNumberFormat()->setFormatCode('_-Rp* #,##0_-;-Rp* #,##0_-;_-* "-"??_-;_-@_-');
        $this->spreadsheet->getActiveSheet()->getStyle('N' . $topRow . ':N' . $nextRow)->getNumberFormat()->setFormatCode('_-Rp* #,##0_-;-Rp* #,##0_-;_-* "-"??_-;_-@_-');
        $this->spreadsheet->getActiveSheet()->getStyle('W' . $topRow . ':W' . $nextRow)->getNumberFormat()->setFormatCode('_-Rp* #,##0_-;-Rp* #,##0_-;_-* "-"??_-;_-@_-');
        $this->spreadsheet->getActiveSheet()->getStyle('Y' . $topRow . ':Y' . $nextRow)->getNumberFormat()->setFormatCode('_-Rp* #,##0_-;-Rp* #,##0_-;_-* "-"??_-;_-@_-');


        $this->spreadsheet->getActiveSheet()->getStyle('B' . $topRow . ':C' . $endRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $this->spreadsheet->getActiveSheet()->getStyle('B' . $topRow . ':N' . $nextRow)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
                'horizontal' => [
                    'borderStyle' => Border::BORDER_NONE,
                ],
            ],
        ]);
        $this->spreadsheet->getActiveSheet()->getStyle('B' . $nextRow . ':N' . $nextRow)->applyFromArray([
            'borders' => [
                'top' => [
                    'borderStyle' => Border::BORDER_MEDIUM,
                ],
            ],
        ]);
        $this->spreadsheet->getActiveSheet()->getStyle('B' . $topHeaderRow . ':N' . $nextRow)->applyFromArray([
            'borders' => [
                'outline' => [
                    'borderStyle' => Border::BORDER_DOUBLE,
                ],
            ],
        ]);
        $nextRow += 3;
        $this->spreadsheet->getActiveSheet()->setCellValue('B' . $nextRow, 'Penjualan');
        $this->spreadsheet->getActiveSheet()->getStyle('B' . $nextRow)->getFont()->setBold(true);
        $topSaleRow = $nextRow;

        setlocale(LC_ALL, 'id-ID', 'id_ID');

        foreach ($penjualan as $idstok) {
            $type = substr($idstok[0], 0, 3);
            $date_str = substr($idstok[0], 4);
            $date = date_create_from_format('ymd', $date_str);
            // $date_formatted = date_format($date, 'F d');
            $date_formatted = strftime('%b %d', $date->getTimestamp());
            $result = isset(FUELTYPE[$type]) ? FUELTYPE[$type] : $type;
            $result .= " " . $date_formatted;

            $this->spreadsheet->getActiveSheet()->setCellValue('C' . $nextRow, $result);
            $this->spreadsheet->getActiveSheet()->setCellValue('D' . $nextRow, $idstok[0]);
            $this->spreadsheet->getActiveSheet()->setCellValue('E' . $nextRow, $idstok[1]);
            $this->spreadsheet->getActiveSheet()->setCellValue('F' . $nextRow, $idstok[2]);
            $this->spreadsheet->getActiveSheet()->setCellValue('G' . $nextRow, "=SUMIF(H$topRow:H$endRow,D$nextRow,K$topRow:K$endRow)");
            $this->spreadsheet->getActiveSheet()->setCellValue('H' . $nextRow, $idstok[3]);
            $nextRow++;
        }
        $this->spreadsheet->getActiveSheet()->setCellValue('E' . $nextRow, '=SUM(E' . $topSaleRow . ':E' . $nextRow - 1 . ')');
        $this->spreadsheet->getActiveSheet()->setCellValue('F' . $nextRow, "=G$nextRow/E$nextRow");
        $this->spreadsheet->getActiveSheet()->setCellValue('G' . $nextRow, '=SUM(G' . $topSaleRow . ':G' . $nextRow - 1 . ')');
        $this->spreadsheet->getActiveSheet()->setCellValue('H' . $nextRow, '=SUM(H' . $topSaleRow . ':H' . $nextRow - 1 . ')');
        $this->spreadsheet->getActiveSheet()->getStyle('E' . $nextRow . ':H' . $nextRow)->getFont()->setBold(true);
        $this->spreadsheet->getActiveSheet()->getStyle('E' . $nextRow . ':H' . $nextRow)->applyFromArray([
            'borders' => [
                'top' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
            ],
        ]);
        $saleSumRow = $nextRow;
        $nextRow += 2;
        $topHPProw = $nextRow;
        $this->spreadsheet->getActiveSheet()->setCellValue('B' . $nextRow, 'HPP');
        $this->spreadsheet->getActiveSheet()->getStyle('B' . $nextRow)->getFont()->setBold(true);
        $this->spreadsheet->getActiveSheet()->setCellValue('C' . $nextRow, 'Persediaan Awal');
        $this->spreadsheet->getActiveSheet()->setCellValue('E' . $nextRow, "=L$topRow");
        $this->spreadsheet->getActiveSheet()->setCellValue('F' . $nextRow, "=G$nextRow/E$nextRow");
        $this->spreadsheet->getActiveSheet()->setCellValue('G' . $nextRow, "=N$topRow");
        $nextRow++;
        $this->spreadsheet->getActiveSheet()->setCellValue('C' . $nextRow, 'Pembelian');
        $this->spreadsheet->getActiveSheet()->setCellValue('E' . $nextRow, "=E$sumRow");
        $this->spreadsheet->getActiveSheet()->setCellValue('F' . $nextRow, "=G$nextRow/E$nextRow");
        $this->spreadsheet->getActiveSheet()->setCellValue('G' . $nextRow, "=G$sumRow");
        $nextRow++;
        $this->spreadsheet->getActiveSheet()->setCellValue('C' . $nextRow, 'Persediaan Akhir');
        $this->spreadsheet->getActiveSheet()->setCellValue('E' . $nextRow, "=L$endRow");
        $this->spreadsheet->getActiveSheet()->setCellValue('F' . $nextRow, "=G$nextRow/E$nextRow");
        $this->spreadsheet->getActiveSheet()->setCellValue('G' . $nextRow, "=N$endRow");
        $nextRow++;
        $HPPSumRow = $nextRow;
        $this->spreadsheet->getActiveSheet()->setCellValue('C' . $nextRow, 'HPP');
        $this->spreadsheet->getActiveSheet()->getStyle('C' . $nextRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        // $this->spreadsheet->getActiveSheet()->setCellValue('E' . $nextRow, '=SUM(E' . $topHPProw . ':E' . $nextRow - 1 . ')');
        $this->spreadsheet->getActiveSheet()->setCellValue('E' . $nextRow, "=E$topHPProw+E" . ($topHPProw + 1) . "-E" . ($nextRow - 1));
        $this->spreadsheet->getActiveSheet()->setCellValue('F' . $nextRow, "=G$nextRow/E$nextRow");
        $this->spreadsheet->getActiveSheet()->setCellValue('G' . $nextRow, "=G$topHPProw+G" . ($topHPProw + 1) . "-G" . ($nextRow - 1));
        // $this->spreadsheet->getActiveSheet()->setCellValue('G' . $nextRow, '=SUM(G' . $topHPProw . ':G' . $nextRow - 1 . ')');
        $this->spreadsheet->getActiveSheet()->getStyle('E' . $nextRow . ':G' . $nextRow)->getFont()->setBold(true);
        $this->spreadsheet->getActiveSheet()->getStyle('E' . $nextRow . ':G' . $nextRow)->applyFromArray([
            'borders' => [
                'top' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
            ],
        ]);
        $nextRow += 2;
        $this->spreadsheet->getActiveSheet()->setCellValue('C' . $nextRow, 'L/R Kotor');
        $this->spreadsheet->getActiveSheet()->setCellValue('G' . $nextRow, "=G$saleSumRow-G$HPPSumRow");
        $this->spreadsheet->getActiveSheet()->getStyle('C' . $nextRow . ':G' . $nextRow)->getFont()->setBold(true);
        $this->spreadsheet->getActiveSheet()->getStyle('C' . $nextRow . ':G' . $nextRow)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFE699');
        $this->spreadsheet->getActiveSheet()->getStyle('E' . $topSaleRow . ':E' . $nextRow)->getNumberFormat()->setFormatCode('* #,##0.00 "L";* -#,##0.00 "L";* "-"??_-;_-@_-');
        $this->spreadsheet->getActiveSheet()->getStyle('F' . $topSaleRow . ':H' . $nextRow)->getNumberFormat()->setFormatCode('_-Rp* #,##0_-;-Rp* #,##0_-;_-* "-"??_-;_-@_-');
    }
    public function generateLossesTable($fuelType, $month, $data)
    {

        $this->spreadsheet->getActiveSheet()->getColumnDimension('P')->setWidth(15);
        $this->spreadsheet->getActiveSheet()->getColumnDimension('Q')->setWidth(15);
        $this->spreadsheet->getActiveSheet()->getColumnDimension('R')->setWidth(15);
        $this->spreadsheet->getActiveSheet()->getColumnDimension('S')->setWidth(16);
        $this->spreadsheet->getActiveSheet()->getColumnDimension('T')->setWidth(15);

        $nextRow = 2;
        $topHeaderRow = $nextRow;

        $this->spreadsheet->getActiveSheet()->mergeCells('P' . $nextRow . ':T' . $nextRow);
        $this->spreadsheet->getActiveSheet()->setCellValue('P' . $nextRow, 'REKAP STOK OPNAME ' . strtoupper($fuelType) . ' 5P.611.16');
        $nextRow++;

        setlocale(LC_ALL, 'id-ID', 'id_ID');
        $month =  strftime("%B %Y", strtotime($month));
        $this->spreadsheet->getActiveSheet()->mergeCells('P' . $nextRow . ':T' . $nextRow);
        $this->spreadsheet->getActiveSheet()->setCellValue('P' . $nextRow, strtoupper($month));

        $this->spreadsheet->getActiveSheet()->getStyle('P' . $topHeaderRow . ':P' . $nextRow)->getFont()->setBold(true);
        $this->spreadsheet->getActiveSheet()->getStyle('P' . $topHeaderRow . ':P' . $nextRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $this->spreadsheet->getActiveSheet()->getStyle('P' . $topHeaderRow . ':P' . $nextRow)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $nextRow++;
        $topTableHeaderRow = $nextRow++;

        $this->spreadsheet->getActiveSheet()->setCellValue('P' . $topTableHeaderRow, 'TANGGAL');
        $this->spreadsheet->getActiveSheet()->setCellValue('Q' . $topTableHeaderRow, 'CM');
        $this->spreadsheet->getActiveSheet()->setCellValue('R' . $topTableHeaderRow, 'LITER');
        $this->spreadsheet->getActiveSheet()->setCellValue('S' . $topTableHeaderRow, 'QTY PERSEDIAAN');
        $this->spreadsheet->getActiveSheet()->setCellValue('T' . $topTableHeaderRow, 'LOSSES');


        $this->spreadsheet->getActiveSheet()->getStyle('P' . $topTableHeaderRow . ':T' . $topTableHeaderRow)->getFont()->setBold(true);
        $this->spreadsheet->getActiveSheet()->getStyle('P' . $topTableHeaderRow . ':T' . $topTableHeaderRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $this->spreadsheet->getActiveSheet()->getStyle('P' . $topTableHeaderRow . ':T' . $topTableHeaderRow)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        $this->spreadsheet->getActiveSheet()->getStyle('P' . $topTableHeaderRow . ':T' . $topTableHeaderRow)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
            ],
        ]);
        $topRow = $nextRow;

        foreach ($data as $stick) {
            $timestamp = Date::PHPToExcel($stick['timestamp']);
            $this->spreadsheet->getActiveSheet()->setCellValue('P' . $nextRow, $timestamp);
            $this->spreadsheet->getActiveSheet()->setCellValue('Q' . $nextRow, $stick['tinggi_cm']);
            $this->spreadsheet->getActiveSheet()->setCellValue('R' . $nextRow, $stick['liter']);
            $this->spreadsheet->getActiveSheet()->setCellValue('S' . $nextRow, $stick['stok_by_app']);
            $this->spreadsheet->getActiveSheet()->setCellValue('T' . $nextRow, $stick['stok_by_app'] - $stick['liter']);
            $nextRow++;
        }
        $this->spreadsheet->getActiveSheet()->setCellValue('Q' . $nextRow, 'JUMLAH');
        $this->spreadsheet->getActiveSheet()->setCellValue('T' . $nextRow, '=SUM(T' . $topRow . ':T' . $nextRow - 1 . ')');
        $this->spreadsheet->getActiveSheet()->getStyle('P' . $topRow . ':P' . $nextRow)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
        $this->spreadsheet->getActiveSheet()->getStyle('P' . $topRow . ':P' . $nextRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $this->spreadsheet->getActiveSheet()->getStyle('Q' . $topRow . ':Q' . $nextRow - 1)->getNumberFormat()->setFormatCode('* #,##0.00 "CM";* #,##0.00 "CM";* - ?? ;-@_-');
        $this->spreadsheet->getActiveSheet()->getStyle('R' . $topRow . ':R' . $nextRow)->getNumberFormat()->setFormatCode('* #,##0.00 "L";* -#,##0.00 "L";* "-"??_-;_-@_-');
        $this->spreadsheet->getActiveSheet()->getStyle('S' . $topRow . ':T' . $nextRow)->getNumberFormat()->setFormatCode('* #,##0.00 "L";* -#,##0.00 "L";* "-"??_-;_-@_-');

        $this->spreadsheet->getActiveSheet()->getStyle('P' . $topRow . ':T' . $nextRow - 1)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
                'horizontal' => [
                    'borderStyle' => Border::BORDER_NONE,
                ],
            ],
        ]);
        $this->spreadsheet->getActiveSheet()->getStyle('P' . $topHeaderRow . ':T' . $nextRow)->applyFromArray([
            'borders' => [
                'outline' => [
                    'borderStyle' => Border::BORDER_DOUBLE,
                ],
            ],
        ]);
    }
}
