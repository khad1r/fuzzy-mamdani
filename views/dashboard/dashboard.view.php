<div class="container mb-md-0 mb-5 pb-5 pb-md-0">
    <div class="d-flex justify-content-center justify-content-lg-between flex-column flex-lg-row mb-lg-0 mb-2">
        <h2 class="text-center"><strong>Dashboard</strong></h2>
        <hr class="d-lg-none d-block">
        <div class="d-flex flex-sm-row justify-content-center">
            <?php require_once './views/components/month_picker.php' ?>
            <?php require_once './views/components/instance_select.php' ?>
        </div>
    </div>
    <hr>
    <div class="row">
        <?php
        require_once './views/components/fuel_desc.php';
        foreach ($data['fuels'] as $fuel) {
        ?>
            <div class="col-md-6 col-lg-6 px-4 mt-2">
                <?php renderHomeDesc($fuel) ?>
                <!-- <div class="">
                    <canvas id="<?= $fuel['jenis_bbm'] ?>Chart" class="grafick"></canvas>
                </div> -->
            </div>
        <?php
        }
        ?>
        <div class="mt-3">
            <h5 class="text-center"><strong>Grafik Penjualan</strong></h5>
            <canvas id="sellingChart" class="grafick"></canvas>
        </div>
        <hr>
        <div class="mt-2">
            <h5 class="text-center"><strong>Grafik Stok</strong></h5>
            <canvas id="stockChart" class="grafick"></canvas>
        </div>
    </div>
    <hr>
    <?php if (App::CheckUser()) { ?>
        <div class="row">
            <div class="col-md-6 col-lg-6  px-4 mt-2">
                <a href="<?= BASEURL ?>/Transaction" class="card-home">
                    <div class="card" style="background-color: #69F0AE;">
                        <div class="card-body row align-items-center">
                            <div class="col-2">
                                <?= file_get_contents("./assets/img/nozzle.svg") ?>
                            </div>
                            <div class="col-10">
                                <h3 class="card-title"><strong>Laporan Transaksi</strong></h3>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-6 col-lg-6  px-4 mt-2">
                <a href="<?= BASEURL ?>/Fuel" class="card-home">
                    <div class="card" style="background-color: #00bcd4;">
                        <div class="card-body row align-items-center">
                            <div class="col-2">
                                <?= file_get_contents("./assets/img/tank.svg") ?>
                            </div>
                            <div class="col-10">
                                <h3 class="card-title"><strong>Laporan Persediaan</strong></h3>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    <?php } ?>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    let active = 'Pertamax';
    let transactionData,
        stokData,
        stickData,
        sellingChart,
        stockChart;

    OptionAll = document.createElement('button');
    OptionAll.value = "All";
    OptionAll.textContent = "All";
    assignBTN(OptionAll);
    instanceDropdown.insertBefore(OptionAll, searchInstanceSelect.nextSibling);
    data = null;
    document.addEventListener('DOMContentLoaded', async function() {
        document.querySelectorAll('.container-fuel-desc').forEach(card => {
            card.addEventListener("click", async (event) => {
                if (active == event.currentTarget.id) return;
                active = event.currentTarget.id;
                document.querySelector(`.container-fuel-desc.active`).classList.remove('active');
                updateGraph()
                document.querySelector(`#${active}`).classList.add('active');
            });
            card.classList.remove('active');
            card.classList.add('button');
            card.classList.add('shadow');
            card.classList.add('p-3');
            card.classList.add('rounded');
        });
        document.querySelector(`#${active}`).classList.add('active');
        [transactionData, stokData, stickData] = await fetchData();
        sellingChart = new Chart(document.querySelector('#sellingChart'), {
            type: 'bar',
            data: {
                labels: transactionData[active].map(d => d.tgl),
                datasets: [{
                    label: 'Penjualan ' + active + ' ' + transactionData[active][0].instansi,
                    data: transactionData[active].map(d => d.total),
                    backgroundColor: '#75caf3'
                }]
            },
            options: {
                aspectRatio: 32 / 9,
                scales: {
                    y: {
                        beginAtZero: true,
                    }
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return `${context.dataset.label} : Rp.${context.formattedValue}`;
                            }
                        }
                    }
                }
            }
        });
        stockChart = new Chart(document.querySelector('#stockChart'), {
            data: {
                datasets: [{
                        type: 'bar',
                        label: `Penjualan ${active} (ltr)`,
                        data: stokData[active].map(d => d.qty_jual)
                    }, {
                        type: 'line',
                        label: `Stok ${active}`,
                        spanGaps: true,
                        data: stokData[active].map(d => d.stok)
                    }, {
                        type: 'line',
                        label: `Opname ${active}`,
                        data: stickData[active].map(d => d.liter)
                    },

                ],
                labels: stokData[active].map(d => d.tgl)
            },
            options: {

                interaction: {
                    mode: 'index'
                },
                aspectRatio: 32 / 9,
                scales: {
                    y: {
                        beginAtZero: true,
                    }
                },
            }
        });
    });
    const fetchData = async () => {
        let instance = instanceSelect.value;
        let month = monthPicker.value;

        let bodyContent = new FormData();

        bodyContent.append("month", month);
        bodyContent.append("instansi", instance ||= 'All');

        let response = await fetch("<?= BASEURL ?>/Dashboard/getRecap/", {
            method: "POST",
            body: bodyContent,
        });
        return await response.json();
    }
    const updateGraph = () => {
        sellingChart.data.labels = transactionData[active].map(d => d.tgl);
        sellingChart.data.datasets[0].data = transactionData[active].map(d => d.total);
        sellingChart.data.datasets[0].label = 'Penjualan ' + active + ' ' + transactionData[active][0].instansi;
        sellingChart.update();
        stockChart.data.labels = stokData[active].map(d => d.tgl);
        stockChart.data.datasets[0].data = stokData[active].map(d => d.qty_jual);
        stockChart.data.datasets[1].data = stokData[active].map(d => d.stok);
        stockChart.data.datasets[2].data = stickData[active].map(d => d.liter);
        stockChart.data.datasets[0].label = `Penjualan ${active} (ltr)`;
        stockChart.data.datasets[1].label = `Stok ${active}`;
        stockChart.data.datasets[2].label = `Opname ${active}`;
        stockChart.update();
    }
    monthPicker.addEventListener("change", async () => {
        [transactionData, stokData, stickData] = await fetchData();
        updateGraph()
    });
    instanceSelect.addEventListener('change', async () => {
        [transactionData, stokData, stickData] = await fetchData();
        updateGraph()
    })
</script>