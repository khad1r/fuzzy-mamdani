import numpy as np
import skfuzzy as fuzz
from skfuzzy import control as ctrl
import matplotlib.pyplot as plt
import argparse

# Menentukan Variabel
universe  = np.arange(0, 60, 1)
hasil     = np.arange(0,100,1)

universe_rendah = fuzz.trapmf(universe, [0, 0, 15, 30])
universe_sedang = fuzz.trimf(universe, [15, 30, 45])
universe_tinggi = fuzz.trapmf(universe, [30, 45, 60, 60])
hasil_kd  = fuzz.trapmf(hasil, [0, 0, 10, 40])
hasil_d   = fuzz.trimf(hasil, [10, 40, 70])
hasil_sd  = fuzz.trapmf(hasil, [40, 70, 100, 100])

def membership_function(value):
  result = {}
  result['rendah'] = fuzz.interp_membership(universe, universe_rendah, value)
  result['sedang'] = fuzz.interp_membership(universe, universe_sedang, value)
  result['tinggi'] = fuzz.interp_membership(universe, universe_tinggi, value)
  
  return result

def membership_function_hasil(value,himp):
  interp = [0]
  if himp == "kd" :
    interp = fuzz.interp_universe(hasil, hasil_kd, value)
  elif himp == "d" :
    interp = fuzz.interp_universe(hasil, hasil_d, value)
  elif himp == "sd" :
    interp = fuzz.interp_universe(hasil, hasil_sd, value)
  return interp[0] # kembalikan hasil pertama dari array

# Parse command-line arguments
parser = argparse.ArgumentParser()
parser.add_argument("a", type=float, help="Visual")
parser.add_argument("b", type=float, help="Auditori")
parser.add_argument("c", type=float, help="Kinestetik")
args = parser.parse_args()

visual_sim = membership_function(args.a)
auditori_sim = membership_function(args.b)
kinestetik_sim = membership_function(args.c)

sd_visual         = [0]
sd_auditori       = [0]
sd_kinestetik     = [0]
d_visual          = [0]
d_auditori        = [0]
d_kinestetik      = [0]
kd_visual         = [0]
kd_auditori       = [0]
kd_kinestetik     = [0]

# Rule Evaluation
apred_rule = np.array([
    np.fmin(visual_sim["tinggi"], np.fmin(auditori_sim["rendah"], kinestetik_sim['rendah'])),
    np.fmin(visual_sim['tinggi'], np.fmin(auditori_sim["rendah"], kinestetik_sim["sedang"])),
    np.fmin(visual_sim["tinggi"], np.fmin(auditori_sim['sedang'], kinestetik_sim['rendah'])),
    np.fmin(visual_sim["tinggi"], np.fmin(auditori_sim['sedang'], kinestetik_sim['sedang'])),
    np.fmin(visual_sim["tinggi"], np.fmin(auditori_sim['rendah'], kinestetik_sim['tinggi'])),
    np.fmin(visual_sim["tinggi"], np.fmin(auditori_sim['sedang'], kinestetik_sim['tinggi'])),
    np.fmin(visual_sim["tinggi"], np.fmin(auditori_sim['tinggi'], kinestetik_sim['rendah'])),
    np.fmin(visual_sim["tinggi"], np.fmin(auditori_sim['tinggi'], kinestetik_sim['sedang'])),
    np.fmin(visual_sim["tinggi"], np.fmin(auditori_sim['tinggi'], kinestetik_sim['tinggi'])),
    np.fmin(visual_sim["rendah"], np.fmin(auditori_sim['rendah'], kinestetik_sim['rendah'])),
    np.fmin(visual_sim["rendah"], np.fmin(auditori_sim['rendah'], kinestetik_sim['sedang'])),
    np.fmin(visual_sim["rendah"], np.fmin(auditori_sim['rendah'], kinestetik_sim['tinggi'])),
    np.fmin(visual_sim["rendah"], np.fmin(auditori_sim['sedang'], kinestetik_sim['tinggi'])),
    np.fmin(visual_sim["rendah"], np.fmin(auditori_sim['sedang'], kinestetik_sim['sedang'])),
    np.fmin(visual_sim["rendah"], np.fmin(auditori_sim['tinggi'], kinestetik_sim['tinggi'])),
    np.fmin(visual_sim["rendah"], np.fmin(auditori_sim['tinggi'], kinestetik_sim['sedang'])),
    np.fmin(visual_sim["rendah"], np.fmin(auditori_sim['sedang'], kinestetik_sim['rendah'])),
    np.fmin(visual_sim["rendah"], np.fmin(auditori_sim['tinggi'], kinestetik_sim['rendah'])),
    np.fmin(visual_sim["sedang"], np.fmin(auditori_sim['sedang'], kinestetik_sim['sedang'])),
    np.fmin(visual_sim["sedang"], np.fmin(auditori_sim['sedang'], kinestetik_sim['rendah'])),
    np.fmin(visual_sim["sedang"], np.fmin(auditori_sim['sedang'], kinestetik_sim['tinggi'])),
    np.fmin(visual_sim["sedang"], np.fmin(auditori_sim['rendah'], kinestetik_sim['rendah'])),
    np.fmin(visual_sim["sedang"], np.fmin(auditori_sim['rendah'], kinestetik_sim['tinggi'])),
    np.fmin(visual_sim["sedang"], np.fmin(auditori_sim['tinggi'], kinestetik_sim['tinggi'])),
    np.fmin(visual_sim["sedang"], np.fmin(auditori_sim['rendah'], kinestetik_sim['sedang'])),
    np.fmin(visual_sim["sedang"], np.fmin(auditori_sim['tinggi'], kinestetik_sim['sedang'])),
    np.fmin(visual_sim["sedang"], np.fmin(auditori_sim["tinggi"], kinestetik_sim["rendah"]))
])

# Rule Activation
z_rule_visual = np.array([
    membership_function_hasil(apred_rule[0],"sd"),
    membership_function_hasil(apred_rule[1],"sd"),
    membership_function_hasil(apred_rule[2],"sd"),
    membership_function_hasil(apred_rule[3],"sd"),
    membership_function_hasil(apred_rule[4],"sd"),
    membership_function_hasil(apred_rule[5],"sd"),
    membership_function_hasil(apred_rule[6],"sd"),
    membership_function_hasil(apred_rule[7],"sd"),
    membership_function_hasil(apred_rule[8],"sd"),
    membership_function_hasil(apred_rule[9],"kd"),
    membership_function_hasil(apred_rule[10],"kd"),
    membership_function_hasil(apred_rule[11],"kd"),
    membership_function_hasil(apred_rule[12],"kd"),
    membership_function_hasil(apred_rule[13],"kd"),
    membership_function_hasil(apred_rule[14],"kd"),
    membership_function_hasil(apred_rule[15],"kd"),
    membership_function_hasil(apred_rule[16],"kd"),
    membership_function_hasil(apred_rule[17],"kd"),
    membership_function_hasil(apred_rule[18],"d"),
    membership_function_hasil(apred_rule[19],"d"),
    membership_function_hasil(apred_rule[20],"d"),
    membership_function_hasil(apred_rule[21],"d"),
    membership_function_hasil(apred_rule[22],"d"),
    membership_function_hasil(apred_rule[23],"d"),
    membership_function_hasil(apred_rule[24],"d"),
    membership_function_hasil(apred_rule[25],"d"),
    membership_function_hasil(apred_rule[26],"d")
])
z_rule_auditori = np.array([
    membership_function_hasil(apred_rule[0],"kd"),
    membership_function_hasil(apred_rule[1],"kd"),
    membership_function_hasil(apred_rule[2],"d"),
    membership_function_hasil(apred_rule[3],"d"),
    membership_function_hasil(apred_rule[4],"kd"),
    membership_function_hasil(apred_rule[5],"d"),
    membership_function_hasil(apred_rule[6],"sd"),
    membership_function_hasil(apred_rule[7],"sd"),
    membership_function_hasil(apred_rule[8],"sd"),
    membership_function_hasil(apred_rule[9],"kd"),
    membership_function_hasil(apred_rule[10],"kd"),
    membership_function_hasil(apred_rule[11],"kd"),
    membership_function_hasil(apred_rule[12],"d"),
    membership_function_hasil(apred_rule[13],"d"),
    membership_function_hasil(apred_rule[14],"sd"),
    membership_function_hasil(apred_rule[15],"sd"),
    membership_function_hasil(apred_rule[16],"d"),
    membership_function_hasil(apred_rule[17],"sd"),
    membership_function_hasil(apred_rule[18],"d"),
    membership_function_hasil(apred_rule[19],"d"),
    membership_function_hasil(apred_rule[20],"d"),
    membership_function_hasil(apred_rule[21],"kd"),
    membership_function_hasil(apred_rule[22],"kd"),
    membership_function_hasil(apred_rule[23],"sd"),
    membership_function_hasil(apred_rule[24],"kd"),
    membership_function_hasil(apred_rule[25],"sd"),
    membership_function_hasil(apred_rule[26],"sd")
])
z_rule_kinestetik = np.array([
    membership_function_hasil(apred_rule[0],"kd"),
    membership_function_hasil(apred_rule[1],"d"),
    membership_function_hasil(apred_rule[2],"kd"),
    membership_function_hasil(apred_rule[3],"d"),
    membership_function_hasil(apred_rule[4],"sd"),
    membership_function_hasil(apred_rule[5],"sd"),
    membership_function_hasil(apred_rule[6],"kd"),
    membership_function_hasil(apred_rule[7],"d"),
    membership_function_hasil(apred_rule[8],"sd"),
    membership_function_hasil(apred_rule[9],"kd"),
    membership_function_hasil(apred_rule[10],"d"),
    membership_function_hasil(apred_rule[11],"sd"),
    membership_function_hasil(apred_rule[12],"sd"),
    membership_function_hasil(apred_rule[13],"d"),
    membership_function_hasil(apred_rule[14],"sd"),
    membership_function_hasil(apred_rule[15],"d"),
    membership_function_hasil(apred_rule[16],"kd"),
    membership_function_hasil(apred_rule[17],"kd"),
    membership_function_hasil(apred_rule[18],"d"),
    membership_function_hasil(apred_rule[19],"kd"),
    membership_function_hasil(apred_rule[20],"sd"),
    membership_function_hasil(apred_rule[21],"kd"),
    membership_function_hasil(apred_rule[22],"sd"),
    membership_function_hasil(apred_rule[23],"sd"),
    membership_function_hasil(apred_rule[24],"d"),
    membership_function_hasil(apred_rule[25],"d"),
    membership_function_hasil(apred_rule[26],"kd")
]) 

# Visualize this

# fig, (ax0, ax1, ax2, ax3) = plt.subplots(nrows=4, figsize=(7, 9))
# ax0.plot(universe, universe_rendah, 'b', linewidth=1.5, label='Rendah')
# ax0.plot(universe, universe_sedang, 'g', linewidth=1.5, label='Sedang')
# ax0.plot(universe, universe_tinggi, 'r', linewidth=1.5, label='Tinggi')
# ax0.set_title('Visual')
# ax0.legend()

# ax1.plot(universe, universe_rendah, 'b', linewidth=1.5, label='Rendah')
# ax1.plot(universe, universe_sedang, 'g', linewidth=1.5, label='Sedang')
# ax1.plot(universe, universe_tinggi, 'r', linewidth=1.5, label='Tinggi')
# ax1.set_title('Auditori')
# ax1.legend()

# ax2.plot(universe, universe_rendah, 'b', linewidth=1.5, label='Rendah')
# ax2.plot(universe, universe_sedang, 'g', linewidth=1.5, label='Sedang')
# ax2.plot(universe, universe_tinggi, 'r', linewidth=1.5, label='Tinggi')
# ax2.set_title('Kinestetik')
# ax2.legend()

# ax3.plot(hasil, hasil_kd, 'b', linewidth=1.5, label='kurang_direkomendasikan')
# ax3.plot(hasil, hasil_d, 'g', linewidth=1.5, label='direkomendasikan')
# ax3.plot(hasil, hasil_sd, 'r', linewidth=1.5, label='sangat_direkomendasikan')
# ax3.set_title('Tipe Gaya Belajar [Visual, Auditori, Kinestetik]')
# ax3.legend()

# # Turn off top/right axes
# for ax in (ax0, ax1, ax2, ax3):
#   ax.spines['top'].set_visible(False)
#   ax.spines['right'].set_visible(False)
#   ax.get_xaxis().tick_bottom()
#   ax.get_yaxis().tick_left()

# plt.tight_layout()
# plt.savefig('assets/export/membership_activity.png', dpi=300, bbox_inches='tight')

# Defuzzifikasi
z_visual      = sum(apred_rule*z_rule_visual)     / sum(apred_rule)
z_auditori    = sum(apred_rule*z_rule_auditori)   / sum(apred_rule)
z_kinestetik  = sum(apred_rule*z_rule_kinestetik) / sum(apred_rule)

print(z_visual,z_auditori,z_kinestetik)
# # Output untuk Tipe Gaya Belajar Visual
# if z_visual <= 10 :
#     print("Tipe Gaya Belajar Visual : Kurang Direkomendasikan")
# if z_visual > 10 and z_visual <= 70 :
#     print("Tipe Gaya Belajar Visual : Direkomendasikan")
# if z_visual > 70 and z_visual < 101 :
#     print("Tipe Gaya Belajar Visual : Sangat Direkomendasikan")

# # Output untuk Tipe Gaya Belajar Auditori
# if z_auditori <= 10 :
#     print("Tipe Gaya Belajar auditori : Kurang Direkomendasikan")
# if z_auditori > 10 and z_auditori <= 70 :
#     print("Tipe Gaya Belajar auditori : Direkomendasikan")
# if z_auditori > 70 and z_auditori < 101 :
#     print("Tipe Gaya Belajar auditori : Sangat Direkomendasikan")

# # Output untuk Tipe Gaya Belajar Kinestetik
# if z_kinestetik <= 10 :
#     print("Tipe Gaya Belajar kinestetik : Kurang Direkomendasikan")
# if z_kinestetik > 10 and z_kinestetik <= 70 :
#     print("Tipe Gaya Belajar kinestetik : Direkomendasikan")
# if z_kinestetik > 70 and z_kinestetik < 101 :
#     print("Tipe Gaya Belajar kinestetik : Sangat Direkomendasikan")
