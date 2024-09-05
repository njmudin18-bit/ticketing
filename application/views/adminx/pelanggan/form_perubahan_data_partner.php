<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="Ticketing Apps - <?php echo $perusahaan->nama; ?>">
  <meta name="author" content="IT Department - <?php echo $perusahaan->nama; ?>">
  <meta name="keywords" content="Ticketing Apps - <?php echo $perusahaan->nama; ?>">
  <link rel="preconnect" href="https://fonts.gstatic.com/">
  <link rel="shortcut icon" href="<?php echo base_url(); ?>upload/general_images/<?php echo $perusahaan->icon_name; ?>" />
  <link rel="canonical" href="<?php echo base_url(); ?>" />
  <title><?php echo $nama_halaman; ?> | <?php echo $perusahaan->nama; ?></title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&amp;display=swap" rel="stylesheet">
  <!-- BEGIN SETTINGS -->
  <!-- Remove this after purchasing -->
  <link class="js-stylesheet" href="<?php echo base_url(); ?>assets/css/light.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>assets/css/customs.css" rel="stylesheet">
  <script src="<?php echo base_url(); ?>assets/js/settings.js"></script>
  <style>
    body {
      opacity: 0;
    }

    .form-check-input:disabled {
      opacity: 1;
    }

    .form-check-input:disabled~.form-check-label,
    .form-check-input[disabled]~.form-check-label {
      opacity: 1;
    }

    .select2-results__option--selectable {
      color: #000;
    }
  </style>
  <!-- END SETTINGS -->
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
</head>

<body data-theme="default" data-layout="fluid" data-sidebar-position="left" data-sidebar-layout="default">
  <div class="wrapper">

    <?php $this->load->view('adminx/components/sidebar'); ?>

    <div class="main">
      <?php $this->load->view('adminx/components/navbar'); ?>

      <main class="content">
        <div class="container-fluid p-0">
          <div class="row">
            <div class="col-12">
              <div class="card table">
                <div class="card-header">
                  <h5 class="card-title text-center">
                    <?php echo $nama_halaman; ?>
                    <span>
                      <button type="button" class="btn btn-primary pull-right text-white btn-sm" onclick="openModal();">
                        <i class="align-middle me-1" data-feather="plus-circle"></i>
                        Show Partner
                      </button>
                    </span>
                  </h5>
                </div>
                <div class="card-body">
                  <div class="container">
                    <form id="formPartner" action="" method="post" enctype="multipart/form-data">
                      <!-- PARTNER -->
                      <div class="row">
                        <div class="col-md-12 mb-3 text-end">
                          <button id="btn_update_partner" type="button" class="btn btn-success btn-sm text-white" onclick="update_data()" disabled>
                            <i class="align-middle me-1 fas fa-fw fa-save"></i>
                            Update Partner
                          </button>
                          <button id="btn_cancel_edit" type="button" class="btn btn-warning btn-sm text-white" onclick="cancelEditPartner()" disabled>
                            <i class="align-middle me-1" data-feather="delete"></i>
                            Cancel
                          </button>
                          <button id="btn_edit_partner" type="button" class="btn btn-danger btn-sm" onclick="editPartner()" disabled>
                            <i class="align-middle me-1" data-feather="edit-2"></i>
                            Edit
                          </button>
                        </div>

                        <div class="col-md-3">
                          <p class="fw-bold">Partner ID</p>
                        </div>
                        <div class="col-md-3">
                          <input type="text" name="partner_id" id="partner_id" class="form-control form-control-sm" disabled>
                          <input type="hidden" name="company_id" id="company_id">
                        </div>
                        <div class="col-md-3">
                          <p class="fw-bold">Revisi</p>
                        </div>
                        <div class="col-md-3">
                          <input type="text" name="revisi_no" id="revisi_no" class="form-control form-control-sm" disabled>
                        </div>

                        <div class="col-md-3">
                          <p class="fw-bold">Partner Name</p>
                        </div>
                        <div class="col-md-9">
                          <input type="text" name="partner_name" id="partner_name" class="form-control form-control-sm" disabled>
                        </div>

                        <div class="col-md-3">
                          <p class="fw-bold">Company Type</p>
                        </div>
                        <div class="col-md-9">
                          <div class="row mb-3">
                            <div class="col-md-3">
                              <label class="form-label me-4">
                                <input type="radio" id="company_type" name="company_type" value="-" class="form-check-input" disabled>
                                <span class="form-check-label ms-1">-</span>
                              </label>
                            </div>
                            <div class="col-md-3">
                              <label class="form-label me-4">
                                <input type="radio" id="company_type" name="company_type" value="CV" class="form-check-input" disabled>
                                <span class="form-check-label ms-1">CV</span>
                              </label>
                            </div>
                            <div class="col-md-3">
                              <label class="form-label me-4">
                                <input type="radio" id="company_type" name="company_type" value="FA" class="form-check-input" disabled>
                                <span class="form-check-label ms-1">FA</span>
                              </label>
                            </div>
                            <div class="col-md-3">
                              <label class="form-label me-4">
                                <input type="radio" id="company_type" name="company_type" value="PD" class="form-check-input" disabled>
                                <span class="form-check-label ms-1">PD</span>
                              </label>
                            </div>
                            <div class="col-md-3">
                              <label class="form-label me-4">
                                <input type="radio" id="company_type" name="company_type" value="PT" class="form-check-input" disabled>
                                <span class="form-check-label ms-1">PT</span>
                              </label>
                            </div>
                            <div class="col-md-3">
                              <label class="form-label me-4">
                                <input type="radio" id="company_type" name="company_type" value="TOKO" class="form-check-input" disabled>
                                <span class="form-check-label ms-1">TOKO</span>
                              </label>
                            </div>
                            <div class="col-md-3">
                              <label class="form-label me-4">
                                <input type="radio" id="company_type" name="company_type" value="UD" class="form-check-input" disabled>
                                <span class="form-check-label ms-1">UD</span>
                              </label>
                            </div>
                          </div>
                        </div>

                        <div class="col-md-3">
                          <p class="fw-bold">Type Partner</p>
                        </div>
                        <div class="col-md-9">
                          <div class="row">
                            <div class="col-md-3">
                              <label class="form-label me-4">
                                <input type="radio" id="type_partner" name="type_partner" value="C" class="form-check-input" disabled>
                                <span class="form-check-label ms-1">Pelanggan</span>
                              </label>
                            </div>
                            <div class="col-md-3">
                              <label class="form-label me-4">
                                <input type="radio" id="type_partner" name="type_partner" value="S" class="form-check-input" disabled>
                                <span class="form-check-label ms-1">Pemasok</span>
                              </label>
                            </div>
                            <div class="col-md-6">
                              <label class="form-label me-4">
                                <input type="radio" id="type_partner" name="type_partner" value="A" class="form-check-input" disabled>
                                <span class="form-check-label ms-1">Pelanggan & Pemasok</span>
                              </label>
                            </div>
                          </div>
                        </div>
                      </div>
                      <hr>
                      <!-- INFO -->
                      <div class="row">
                        <div class="col-md-12 mb-3">
                          <h4><strong>INFO</strong></h4>
                        </div>
                        <div class="col-md-3">
                          <p class="fw-bold">Kontak</p>
                        </div>
                        <div class="col-md-9">
                          <input type="text" name="kontak" id="kontak" class="form-control form-control-sm" disabled>
                        </div>

                        <div class="col-md-3">
                          <p class="fw-bold">Alamat</p>
                        </div>
                        <div class="col-md-9">
                          <input type="text" name="alamat" id="alamat" class="form-control form-control-sm" disabled>
                        </div>

                        <div class="col-md-3">
                          <p class="fw-bold">Kota</p>
                        </div>
                        <div class="col-md-3">
                          <input type="text" name="kota" id="kota" class="form-control form-control-sm" disabled>
                        </div>
                        <div class="col-md-3">
                          <p class="fw-bold">Negara</p>
                        </div>
                        <div class="col-md-3">
                          <input type="text" name="negara" id="negara" class="form-control form-control-sm" disabled>
                        </div>

                        <div class="col-md-3">
                          <p class="fw-bold">Fax</p>
                        </div>
                        <div class="col-md-3">
                          <input type="text" name="fax" id="fax" class="form-control form-control-sm" disabled>
                        </div>
                        <div class="col-md-3">
                          <p class="fw-bold">Telex</p>
                        </div>
                        <div class="col-md-3">
                          <input type="text" name="telex" id="telex" class="form-control form-control-sm" disabled>
                        </div>

                        <div class="col-md-3">
                          <p class="fw-bold">No PKP</p>
                        </div>
                        <div class="col-md-3">
                          <input type="text" name="no_pkp" id="no_pkp" class="form-control form-control-sm" disabled>
                        </div>
                        <div class="col-md-3">
                          <p class="fw-bold">Tanggal PKP</p>
                        </div>
                        <div class="col-md-3">
                          <input type="text" name="tanggal_pkp" id="tanggal_pkp" class="form-control form-control-sm" disabled>
                          <input type="hidden" name="tanggal_pkp_real" id="tanggal_pkp_real">
                        </div>

                        <div class="col-md-3">
                          <p class="fw-bold">Telepon</p>
                        </div>
                        <div class="col-md-3">
                          <input type="text" name="telepon" id="telepon" class="form-control form-control-sm" disabled>
                        </div>
                        <div class="col-md-3">
                          <p class="fw-bold">Email</p>
                        </div>
                        <div class="col-md-3">
                          <input type="email" name="email" id="email" class="form-control form-control-sm" disabled>
                        </div>

                        <div class="col-md-3">
                          <p class="fw-bold">Website</p>
                        </div>
                        <div class="col-md-3">
                          <input type="text" name="website" id="website" class="form-control form-control-sm" disabled>
                        </div>
                        <div class="col-md-3">
                          <p class="fw-bold">NPWP</p>
                        </div>
                        <div class="col-md-3">
                          <input type="text" name="npwp" id="npwp" class="form-control form-control-sm" disabled>
                        </div>

                      </div>
                      <hr>
                      <!-- ACCOUNT -->
                      <div class="row">
                        <div class="col-md-12 mb-3">
                          <h4><strong>ACCOUNT</strong></h4>
                        </div>

                        <div class="col-md-3">
                          <p class="fw-bold">Tempo Pembayaran</p>
                        </div>
                        <div class="col-md-9">
                          <div class="row">
                            <div class="col-md-4">
                              <input type="text" name="tempo_pembayaran" id="tempo_pembayaran" class="form-control form-control-sm" disabled>
                            </div>
                            <div class="col-md-8">
                              <p>Day(s)</p>
                            </div>
                          </div>
                        </div>

                        <div class="col-md-3">
                          <p class="fw-bold">Mata Uang AP</p>
                        </div>
                        <div class="col-md-9">
                          <div class="row">
                            <div class="col-md-4">
                              <select name="mata_uang_ap" id="mata_uang_ap" class="form-select form-select-sm" disabled>
                                <option value="IDR">IDR</option>
                                <option value="RMB">RMB</option>
                                <option value="USD">USD</option>
                              </select>
                            </div>
                            <div class="col-md-8"></div>
                          </div>
                        </div>

                        <div class="col-md-3">
                          <p class="fw-bold">Mata Uang PO</p>
                        </div>
                        <div class="col-md-9">
                          <div class="row">
                            <div class="col-md-4">
                              <select name="mata_uang_po" id="mata_uang_po" class="form-select form-select-sm" disabled>
                                <option value="IDR">IDR</option>
                                <option value="RMB">RMB</option>
                                <option value="USD">USD</option>
                              </select>
                            </div>
                            <div class="col-md-8"></div>
                          </div>
                        </div>

                        <div class="col-md-3">
                          <p class="fw-bold">Tipe Pembayaran</p>
                        </div>
                        <div class="col-md-9">
                          <!-- <p id="tipe_pembayaran">T/T</p> -->
                          <div class="row">
                            <div class="col-md-4">
                              <input type="text" name="tipe_pembayaran" id="tipe_pembayaran" class="form-control form-control-sm" disabled>
                            </div>
                            <div class="col-md-8"></div>
                          </div>
                        </div>

                        <div class="col-md-3">
                          <p class="fw-bold">Batas Kredit</p>
                        </div>
                        <div class="col-md-9">
                          <div class="row">
                            <div class="col-md-4">
                              <input type="text" name="batas_kredit" id="batas_kredit" class="form-control form-control-sm" disabled>
                            </div>
                            <div class="col-md-8"></div>
                          </div>
                        </div>

                        <div class="col-md-3">
                          <p class="fw-bold">Pajak PPN</p>
                        </div>
                        <div class="col-md-9">
                          <div class="row mb-3">
                            <div class="col-md-3">
                              <label class="form-label me-4">
                                <input type="radio" id="pajak_ppn" name="pajak_ppn" value="N" class="form-check-input" disabled>
                                <span class="form-check-label ms-1">None</span>
                              </label>
                            </div>
                            <div class="col-md-3">
                              <label class="form-label me-4">
                                <input type="radio" id="pajak_ppn" name="pajak_ppn" value="I" class="form-check-input" disabled>
                                <span class="form-check-label ms-1">Include</span>
                              </label>
                            </div>
                            <div class="col-md-6">
                              <label class="form-label me-4">
                                <input type="radio" id="pajak_ppn" name="pajak_ppn" value="E" class="form-check-input" disabled>
                                <span class="form-check-label ms-1">Exclude</span>
                              </label>
                            </div>
                          </div>
                        </div>

                        <div class="col-md-3">
                          <p class="fw-bold">Masa Berlaku PO</p>
                        </div>
                        <div class="col-md-9">
                          <div class="row">
                            <div class="col-md-4">
                              <input type="text" name="masa_berlaku_po" id="masa_berlaku_po" class="form-control form-control-sm" disabled>
                            </div>
                            <div class="col-md-8">
                              <p>Day(s) from SO Date</p>
                            </div>
                          </div>
                        </div>
                      </div>
                      <hr>
                      <!-- SHIPMENT ADDRESS -->
                      <div class="row">
                        <div class="col-md-12 mb-3">
                          <h4><strong>ALAMAT PENGIRIMAN</strong></h4>
                        </div>

                        <div class="col-md-3">
                          <p class="fw-bold">ID Pengiriman</p>
                        </div>
                        <div class="col-md-9">
                          <input type="text" name="id_pengiriman" id="id_pengiriman" class="form-control form-control-sm" disabled>
                        </div>

                        <div class="col-md-3">
                          <p class="fw-bold">Nama Penerima</p>
                        </div>
                        <div class="col-md-9">
                          <input type="text" name="nama_penerima_pengiriman" id="nama_penerima_pengiriman" class="form-control form-control-sm" disabled>
                        </div>

                        <div class="col-md-3">
                          <p class="fw-bold">Alamat Pengiriman</p>
                        </div>
                        <div class="col-md-9">
                          <input type="text" name="alamat_pengiriman" id="alamat_pengiriman" class="form-control form-control-sm" disabled>
                        </div>
                        <div class="col-md-3">
                          <p class="fw-bold">Kota</p>
                        </div>
                        <div class="col-md-9">
                          <input type="text" name="kota_pengiriman" id="kota_pengiriman" class="form-control form-control-sm" disabled>
                        </div>
                        <div class="col-md-3">
                          <p class="fw-bold">Kontak</p>
                        </div>
                        <div class="col-md-3">
                          <input type="text" name="kontak_pengiriman" id="kontak_pengiriman" class="form-control form-control-sm" disabled>
                        </div>
                        <div class="col-md-3">
                          <p class="fw-bold">Telepon</p>
                        </div>
                        <div class="col-md-3">
                          <input type="text" name="telepon_pengiriman" id="telepon_pengiriman" class="form-control form-control-sm" disabled>
                        </div>
                        <div class="col-md-3">
                          <p class="fw-bold">Note</p>
                        </div>
                        <div class="col-md-3">
                          <input type="text" name="note_pengiriman" id="note_pengiriman" class="form-control form-control-sm" disabled>
                        </div>
                        <div class="col-md-3">
                          <p class="fw-bold">Aktif</p>
                        </div>
                        <div class="col-md-3">
                          <p id="aktif_pengiriman_id">
                            <input type="checkbox" name="aktif_pengiriman" id="aktif_pengiriman" class="form-check-input" disabled>
                          </p>
                        </div>
                        <div class="col-md-3">
                          <p class="fw-bold">Pajak</p>
                        </div>
                        <div class="col-md-3">
                          <p id="pajak_pengiriman_id">
                            <input type="checkbox" name="pajak_pengiriman" id="pajak_pengiriman" class="form-check-input" disabled>
                          </p>
                        </div>
                        <div class="col-md-3">
                          <p class="fw-bold">Connection</p>
                        </div>
                        <div class="col-md-3">
                          <input type="text" name="connection_pengiriman" id="connection_pengiriman" class="form-control form-control-sm" disabled>
                        </div>
                        <div class="col-md-3">
                          <p class="fw-bold">Kode Lokasi</p>
                        </div>
                        <div class="col-md-3">
                          <input type="text" name="kode_lokasi_pengiriman" id="kode_lokasi_pengiriman" class="form-control form-control-sm" disabled>
                        </div>
                        <div class="col-md-3">
                          <p class="fw-bold">Kode Wilayah</p>
                        </div>
                        <div class="col-md-3">
                          <input type="text" name="kode_wilayah_pengiriman" id="kode_wilayah_pengiriman" class="form-control form-control-sm" disabled>
                        </div>
                        <div class="col-md-3">
                          <p class="fw-bold">Kode Cabang</p>
                        </div>
                        <div class="col-md-9">
                          <input type="text" name="kode_cabang_pengiriman" id="kode_cabang_pengiriman" class="form-control form-control-sm" disabled>
                        </div>
                        <div class="col-md-3">
                          <p class="fw-bold">Lokasi Cabang</p>
                        </div>
                        <div class="col-md-9">
                          <input type="text" name="lokasi_cabang_pengiriman" id="lokasi_cabang_pengiriman" class="form-control form-control-sm" disabled>
                        </div>
                        <div class="col-md-3">
                          <p class="fw-bold">Kode Perusahaan</p>
                        </div>
                        <div class="col-md-9">
                          <p id="kode_perusahaan_pengiriman_id">
                            <input type="checkbox" name="kode_perusahaan_pengiriman" id="kode_perusahaan_pengiriman" class="form-check-input" disabled>
                          </p>
                        </div>
                      </div>
                      <hr>
                      <!-- LAMPIRAN DOKUMEN NEW -->
                      <div class="row">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                          <h4><strong>LAMPIRAN KELENGKAPAN DOKUMEN</strong></h4>
                          <!-- <button type="button" id="edit_lampiran" class="btn btn-primary btn-sm" onclick="edit_lampiran();">Edit Lampiran</button> -->
                        </div>

                        <div class="row">
                          <div class="col-md-2 col-sm-4 mb-3">
                            <input type="checkbox" id="npwp_doc" name="npwp_doc" class="form-check-input" disabled>
                            <span class="form-check-label">NPWP</span>
                          </div>
                          <div class="col-md-4 col-sm-8 mb-3">
                            <input type="file" name="npwp_file" id="npwp_file" class="form-control form-control-sm" disabled accept=".png, .pdf">
                            <input type="text" name="npwp_file_info" id="npwp_file_info" class="form-control form-control-sm" disabled>
                          </div>

                          <div class="col-md-2 col-sm-4 mb-3">
                            <input type="checkbox" id="nib_doc" name="nib_doc" class="form-check-input" disabled>
                            <span class="form-check-label">NIB</span>
                          </div>
                          <div class="col-md-4 col-sm-8 mb-3">
                            <input type="file" name="nib_file" id="nib_file" class="form-control form-control-sm" disabled accept=".png, .pdf">
                            <input type="text" name="nib_file_info" id="nib_file_info" class="form-control form-control-sm" disabled>
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-md-2 col-sm-4 mb-3">
                            <input type="checkbox" id="tdp_doc" name="tdp_doc" class="form-check-input" disabled>
                            <span class="form-check-label">TDP</span>
                          </div>
                          <div class="col-md-4 col-sm-8 mb-3">
                            <input type="file" name="tdp_file" id="tdp_file" class="form-control form-control-sm" disabled accept=".png, .pdf">
                            <input type="text" name="tdp_file_info" id="tdp_file_info" class="form-control form-control-sm" disabled>
                          </div>

                          <div class="col-md-2 col-sm-4 mb-3">
                            <input type="checkbox" id="ktp_directur_doc" name="ktp_directur_doc" class="form-check-input" disabled>
                            <span class="form-check-label">KTP Direktur</span>
                          </div>
                          <div class="col-md-4 col-sm-8 mb-3">
                            <input type="file" name="ktp_directur_file" id="ktp_directur_file" class="form-control form-control-sm" disabled accept=".png, .pdf">
                            <input type="text" name="ktp_directur_file_info" id="ktp_directur_file_info" class="form-control form-control-sm" disabled>
                          </div>
                        </div>


                        <div class="row">
                          <div class="col-md-2 col-sm-4 mb-3">
                            <input type="checkbox" id="sppkp_doc" name="sppkp_doc" class="form-check-input" disabled>
                            <span class="form-check-label">SPPKP</span>
                          </div>
                          <div class="col-md-4 col-sm-8 mb-3">
                            <input type="file" name="sppkp_file" id="sppkp_file" class="form-control form-control-sm" disabled accept=".png, .pdf">
                            <input type="text" name="sppkp_file_info" id="sppkp_file_info" class="form-control form-control-sm" disabled>
                          </div>

                          <div class="col-md-2 col-sm-4 mb-3">
                            <input type="checkbox" id="spesimen_ttd_doc" name="spesimen_ttd_doc" class="form-check-input" disabled>
                            <span class="form-check-label">Spesimen Nama, TTD</span>
                          </div>
                          <div class="col-md-4 col-sm-8 mb-3">
                            <input type="file" name="spesimen_ttd_file" id="spesimen_ttd_file" class="form-control form-control-sm" disabled accept=".png, .pdf">
                            <input type="text" name="spesimen_ttd_file_info" id="spesimen_ttd_file_info" class="form-control form-control-sm" disabled>
                          </div>
                        </div>
                      </div>
                      <hr>
                      <!-- INFORMASI TAMBAHAN DAN PERUBAHAN -->
                      <div class="row">
                        <div class="col-md-12 mb-3">
                          <h4><strong>INFORMASI TAMBAHAN DAN PERUBAHAN</strong></h4>
                        </div>

                        <div class="col-md-12">
                          <textarea id="informasi_tambahan" name="informasi_tambahan"></textarea>
                        </div>
                      </div>
                    </form>
                    <!-- <hr> -->
                    <!-- TANDA TANGAN -->
                    <!-- <div class="row">
                        <div class="col-md-12 mb-3">
                          <h4><strong>TANDA TANGAN</strong></h4>
                        </div>

                        <?php
                        foreach ($signatures as $key => $value) {
                        ?>
                            <div class="col-md-3 text-center">
                              <p class="mb-6"><?php echo $value->PreparedTitle; ?></p>
                              <p class="mb-2"><?php echo $value->PreparedBy; ?></p>
                              <p>Dept. <?php echo $value->PreparedDepartment; ?></p>
                            </div>
                            <div class="col-md-3 text-center">
                              <p class="mb-6"><?php echo $value->CheckedTitle; ?></p>
                              <p class="mb-2"><?php echo $value->CheckedBy; ?></p>
                              <p>Dept. <?php echo $value->CheckedDepartment; ?></p>
                            </div>
                            <div class="col-md-3 text-center">
                              <p class="mb-6"><?php echo $value->ApprovedTitle; ?></p>
                              <p class="mb-2"><?php echo $value->ApprovedBy; ?></p>
                              <p><?php echo $value->ApprovedDepartment; ?></p>
                            </div>
                          <?php
                        }
                          ?>

                        <div class="col-md-3 text-center">
                          <p class="mb-6">Dikerjakan oleh</p>
                          <p class="mb-2"><?php echo $this->session->userdata('user_realName'); ?></p>
                          <p>Dept. IT</p>
                        </div>
                      </div> -->
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </main>

      <?php $this->load->view('adminx/components/footer'); ?>
    </div>
  </div>

  <!-- MODAL PILIH PARTNER -->
  <div class="modal fade" id="modalForm" role="dialog" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Pilih Partner</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="" method="post" id="terapkanForm">
            <input type="hidden" value="" name="kode">
            <div class="form-group row mb-3">
              <label class="col-sm-4 col-form-label">Perusahaan</label>
              <div class="col-sm-8">
                <select id="perusahaan" name="perusahaan" class="form-select" onchange="get_partner()">
                  <option selected disabled="disabled">-- Pilih --</option>
                  <?php foreach ($perusahaan_all as $key => $value) : ?>
                    <option value="<?php echo $value->id; ?>"><?php echo $value->nama; ?></option>
                  <?php endforeach ?>
                </select>
                <span class="help-block"></span>
              </div>
            </div>
            <div class="form-group row mb-3">
              <label class="col-sm-4 col-form-label">Pilih Partner</label>
              <div class="col-sm-8">
                <select id="partner" name="partner" class="form-select pilih-partner" required="required" width="100%" onchange="get_partner_revisi()">
                  <option selected="selected" disabled="disabled">-- Pilih --</option>
                </select>
                <span class="help-block"></span>
              </div>
            </div>
            <div class="form-group row mb-3">
              <label class="col-sm-4 col-form-label">Pilih Partner Revisi</label>
              <div class="col-sm-8">
                <select id="revisi" name="revisi" class="form-select" required="required" width="100%">
                  <option selected="selected" disabled="disabled">-- Pilih --</option>
                </select>
                <span class="help-block"></span>
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" id="terapkan" class="btn btn-primary" onclick="terapkan();">Terapkan</button>
        </div>
      </div>
    </div>
  </div>

  <div id="loading-screen" class="loading">Loading</div>

  <script src="<?php echo base_url(); ?>assets/js/app.js"></script>
  <script src="<?php echo base_url(); ?>assets/js/datatables.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.14.1/moment.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
  <script>
    $(document).ready(function() {
      $('#btn_update_partner').prop("disabled", true);
      $('#btn_cancel_edit').prop("disabled", true);
      $('#btn_edit_partner').prop("disabled", true);

      // Daftar checkbox yang akan dipantau
      var checkboxes = ['#npwp_doc', '#nib_doc', '#tdp_doc', '#sppkp_doc', '#ktp_directur_doc',
        '#spesimen_ttd_doc',
      ];

      // Saat salah satu checkbox berubah
      $(checkboxes.join(', ')).change(function() {
        var checkboxID = $(this).attr('id');
        var isChecked = $(this).is(':checked');

        // Penentuan ID dari input file terkait
        var fileInputID = '#' + checkboxID.replace('_doc', '_file');
        // Mengatur status disabled input file berdasarkan status checkbox
        $(fileInputID).prop('disabled', !isChecked);
      });

      // Set status awal untuk input files
      checkboxes.forEach(function(checkboxID) {
        var fileInputID = checkboxID.replace('_doc', '_file');
        $(fileInputID).prop('disabled', !$(checkboxID).is(':checked'));
      });

      // Dapatkan objek Summernote
      var summernoteTextarea = $('#informasi_tambahan');

      // Reset nilai Summernote
      summernoteTextarea.summernote('reset');
      summernoteTextarea.summernote('disable');
    });

    function edit_lampiran() {
      console.log('edit lampiran');
    }


    function clearForm() {
      console.log('clearForm()');
      var summernoteTextarea = $('#informasi_tambahan');

      // Reset nilai Summernote
      summernoteTextarea.summernote('reset');
      summernoteTextarea.summernote('disable');

      let radios = document.querySelectorAll('input[type="radio"]');
      for (let i = 0; i < radios.length; i++) {
        radios[i].disabled = true;
      }

      // Mendapatkan semua elemen input file dalam form
      var fileInputs = document.querySelectorAll('input[type="file"]');
      // Mengosongkan nilai dari semua input file
      fileInputs.forEach(function(fileInput) {
        fileInput.value = '';
        fileInput.disabled = true;
      });

      let textsInput = document.querySelectorAll("input[type='text']");
      textsInput.forEach((input) => {
        input.disabled = true;
        input.value = '';
      });

      let checkboxes = document.querySelectorAll('input[type="checkbox"]');
      for (let i = 0; i < checkboxes.length; i++) {
        checkboxes[i].checked = false;
        checkboxes[i].disabled = true;
      }

      let emails = document.querySelectorAll('input[type="email"]');
      for (let i = 0; i < emails.length; i++) {
        emails[i].value = '';
        emails[i].disabled = true;
      }

      let selects = document.querySelectorAll('select');
      for (let i = 0; i < selects.length; i++) {
        selects[i].disabled = true;
      }

    }

    //FUNCTION UPDATE DATA
    function update_data() {

      var formData = new FormData($('#formPartner')[0]);
      let pajak_pengiriman = $('#pajak_pengiriman').is(":checked");
      let aktif_pengiriman = $('#aktif_pengiriman').is(":checked");
      let kode_perusahaan_pengiriman = $('#kode_perusahaan_pengiriman').is(":checked");
      $.ajax({
        url: '<?php echo base_url(); ?>pelanggan/update_data',
        dataType: 'JSON',
        cache: false,
        contentType: false,
        processData: false,
        data: formData,
        type: 'POST',
        beforeSend: function(response) {
          $("#btn_update_partner").prop('disabled', true);
          $("#btn_update_partner").html(
            '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
        },
        success: function(data) {
          if (data.status == 'ok') //if success close modal and reload ajax table
          {
            Swal.fire(
              'success',
              'Data berhasil diupload',
              'success',
            );

            $('#btn_edit_partner').prop("disabled", true);
            $('#btn_update_partner').prop("disabled", true);
            $('#btn_cancel_edit').prop("disabled", true);
            clearForm();
          } else if (data.status == 'gagal') //if success close modal and reload ajax table
          {
            Swal.fire(
              'FORBIDDEN',
              data.message,
              'error',
            );
            $('#btn_update_partner').attr('disabled', false); //set button enable 

          } else {
            Swal.fire(
              'FORBIDDEN',
              'Access Denied',
              'info',
            )
          }
          $('#btn_update_partner').html(
            '<i class="align-middle me-1" data-feather="save"></i> Update Data'); //change button text
          $('#btn_update_partner').attr('disabled', true); //set button enable 
        },
        error: function(response) {
          alert('Error when adding / update data');
          $('#btn_update_partner').html(
            '<i class="align-middle me-1" data-feather="save"></i> Update Data'); //change button text
          $('#btn_update_partner').attr('disabled', false); //set button enable 
        }
      });
    }

    function update_data_old() {
      var form = $('#formPartner')[0];
      var form_data = new FormData(form);
      let pajak_pengiriman = $('#pajak_pengiriman').is(":checked");
      let aktif_pengiriman = $('#aktif_pengiriman').is(":checked");
      let kode_perusahaan_pengiriman = $('#kode_perusahaan_pengiriman').is(":checked");

      //DOCUMENT
      let npwp_doc = $('#npwp_doc').is(":checked");
      let nib_doc = $('#nib_doc').is(":checked");
      let tdp_doc = $('#tdp_doc').is(":checked");
      let sppkp_doc = $('#sppkp_doc').is(":checked");
      let ktp_directur_doc = $('#ktp_directur_doc').is(":checked");
      let spesimen_ttd_doc = $('#spesimen_ttd_doc').is(":checked");

      form_data.append('pajak_pengiriman_new', pajak_pengiriman == true ? '1' : '0');
      form_data.append('aktif_pengiriman_new', aktif_pengiriman == true ? '1' : '0');
      form_data.append('kode_perusahaan_pengiriman_new', kode_perusahaan_pengiriman == true ? '1' : '0');

      form_data.append('npwp_doc_new', npwp_doc == true ? '1' : '0');
      form_data.append('nib_doc_new', nib_doc == true ? '1' : '0');
      form_data.append('tdp_doc_new', tdp_doc == true ? '1' : '0');
      form_data.append('sppkp_doc_new', sppkp_doc == true ? '1' : '0');
      form_data.append('ktp_directur_doc_new', ktp_directur_doc == true ? '1' : '0');
      form_data.append('spesimen_ttd_doc_new', spesimen_ttd_doc == true ? '1' : '0');

      $.ajax({
        url: '<?php echo base_url(); ?>pelanggan/update_data',
        dataType: 'JSON',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'POST',
        beforeSend: function(response) {
          $("#btn_update_partner").prop('disabled', true);
          $("#btn_update_partner").html(
            '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
        },
        success: function(data) {
          if (data.status == 'success') //if success close modal and reload ajax table
          {
            //reload_table();
          } else {
            Swal.fire(
              'FORBIDDEN',
              'Access Denied',
              'info',
            )
          }
          $('#btn_update_partner').html(
            '<i class="align-middle me-1" data-feather="save"></i> Update Data'); //change button text
          $('#btn_update_partner').attr('disabled', false); //set button enable 
        },
        error: function(response) {
          alert('Error when adding / update data');
          $('#btn_update_partner').html(
            '<i class="align-middle me-1" data-feather="save"></i> Update Data'); //change button text
          $('#btn_update_partner').attr('disabled', false); //set button enable 
        }
      });
    }


    //EDIT PARTNER
    function editPartner() {
      $('#btn_update_partner').prop("disabled", false);
      $('#btn_cancel_edit').prop("disabled", false);
      $('#btn_edit_partner').prop("disabled", true);
      // Dapatkan objek Summernote
      var summernoteTextarea = $('#informasi_tambahan');
      summernoteTextarea.summernote('enable');

      let textsInput = document.querySelectorAll("input[type='text']");

      var fileInfo = ['npwp_file_info', 'nib_file_info', 'tdp_file_info', 'ktp_directur_file_info', 'sppkp_file_info',
        'spesimen_ttd_file_info'
      ];

      textsInput.forEach((input) => {
        // Menggunakan includes() untuk memeriksa keberadaan elemen dalam array fileInfo
        if (fileInfo.includes(input.id)) {
          input.disabled = true;
        } else {
          input.disabled = false;
        }
      });

      let checkboxes = document.querySelectorAll('input[type="checkbox"]');
      for (let i = 0; i < checkboxes.length; i++) {
        checkboxes[i].disabled = false;
      }

      let radios = document.querySelectorAll('input[type="radio"]');
      for (let i = 0; i < radios.length; i++) {
        radios[i].disabled = false;
      }

      let emails = document.querySelectorAll('input[type="email"]');
      for (let i = 0; i < emails.length; i++) {
        emails[i].disabled = false;
      }

      let selects = document.querySelectorAll('select');
      for (let i = 0; i < selects.length; i++) {
        selects[i].disabled = false;
      }

    }

    //CANCEL EDIT PARTNER
    function cancelEditPartner() {
      // Dapatkan objek Summernote
      var summernoteTextarea = $('#informasi_tambahan');

      summernoteTextarea.summernote('disable');
      $('#btn_update_partner').prop("disabled", true);
      $('#btn_cancel_edit').prop("disabled", true);
      $('#btn_edit_partner').prop("disabled", false);

      let textsInput = document.querySelectorAll("input[type='text']");
      textsInput.forEach((input) => {
        input.disabled = true;
      });

      let radios = document.querySelectorAll('input[type="radio"]');
      for (let i = 0; i < radios.length; i++) {
        radios[i].disabled = true;
      }

      let checkboxes = document.querySelectorAll('input[type="checkbox"]');
      for (let i = 0; i < checkboxes.length; i++) {
        checkboxes[i].disabled = true;
      }

      let emails = document.querySelectorAll('input[type="email"]');
      for (let i = 0; i < emails.length; i++) {
        emails[i].disabled = true;
      }

      let selects = document.querySelectorAll('select');
      for (let i = 0; i < selects.length; i++) {
        selects[i].disabled = true;
      }

    }

    function get_partner() {
      var company_id = $("#perusahaan :selected").val();
      $(".pilih-partner").empty();

      $.ajax({
        url: "<?php echo base_url(); ?>pelanggan/get_partner_data",
        method: "POST",
        data: {
          id_perusahaan: company_id
        },
        dataType: 'json',
        success: function(data) {
          $(".pilih-partner").select2({
            data: data.data,
            placeholder: "-- Pilih --",
            allowClear: true,
            width: '100%',
            dropdownParent: $("#modalForm")
          });
        },
        error: function(jqXHR, textStatus, errorThrown) {
          alert('Error when getting partner data');
        }
      });
    }

    function get_partner_revisi() {
      var company_id = $("#perusahaan :selected").val();
      let partner_id = $("#partner :selected").val();

      $.ajax({
        url: "<?php echo base_url(); ?>pelanggan/get_partner_revisi",
        method: "POST",
        data: {
          id_perusahaan: company_id,
          id_partner: partner_id
        },
        dataType: 'json',
        success: function(data) {
          if (data.status_code == 200) {

            var i;
            var html = '';
            html = '<option selected disabled>-- Pilih --</option>';
            for (i = 0; i < data.data.length + 1; i++) {
              (i == data.data.length) ? html += '<option selected="selected" value="' + i + '">Revisi ' + i +
                ' <span class="badge bg-danger">New</span>' +
                '</option>':
                html += '<option value="' + i + '">Revisi ' + i +
                '</option>';
            }
            $('#revisi').html(html);

          } else {
            $('#revisi').empty().append(
              '<option selected="selected" value="0">Revisi 0   <span class="badge bg-danger">New</span></option>'
            );
          }
        },
        error: function(jqXHR, textStatus, errorThrown) {
          alert('Error when getting partner revisi data');
        }
      });
    }

    function currency(price) {
      let prices = new Intl.NumberFormat('de-DE', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
      }).format(price);
      return prices;
    }


    function terapkan() {
      var perusahaan_id = $("#perusahaan").val();
      var partner_id = $("#partner").val();
      var revisi = $("#revisi").val();

      $("#company_id").val(perusahaan_id);

      if (perusahaan_id == null || perusahaan_id == '') {
        alert('Perusahaan harus dipilih!');
        $("#perusahaan").focus();

        return false;
      } else if (partner_id == null || partner_id == '') {
        alert('Partner harus dipilih!');
        $("#partner").focus();

        return false;
      } else {

        $.ajax({
          url: "<?php echo base_url(); ?>pelanggan/get_partner",
          method: "POST",
          data: {
            id_partner: partner_id,
            id_perusahaan: perusahaan_id,
            revision: revisi
          },
          dataType: 'json',
          success: function(data) {

            if (data.status_code == 200) {
              // Setelah berhasil, reset formulir
              $("#terapkanForm")[0].reset();
              //kosongkan nilai
              $(".pilih-partner").empty();
              $("#revisi").empty();
              //beri nilai default
              var option = new Option("-- Pilih --", "", true, true);
              $(".pilih-partner").append(option);
              $("#revisi").append(option);
              //tutup modal
              $('#modalForm').modal('hide');
              clearForm()

              if (data.lampiran != null) {
                let nama_file = data.lampiran.file;

                for (var element of nama_file) {
                  let tampung = element.split('-');
                  let checkbox = tampung[0] + '_doc';
                  let input_file = tampung[0] + '_file';
                  let input_file_info = tampung[0] + '_file_info';
                  let nama_file = element;
                  $('#' + input_file_info).val(nama_file);
                }

                if (data.lampiran.informasi != null) {
                  // Dapatkan objek Summernote
                  var summernoteTextarea = $('#informasi_tambahan');
                  // Set nilai awal untuk Summernote // Reset nilai Summernote
                  summernoteTextarea.summernote('reset');
                  summernoteTextarea.summernote('disable');
                  summernoteTextarea.summernote('code', data.lampiran.informasi);
                }
              }

              //SET TO VIEW
              $("#partner_id").val(data.partner_info.PartnerID);
              $("#revisi_no").val(revisi);
              $("#partner_name").val(data.partner_info.PartnerName);
              $(":radio[name='company_type'][value='" + data.partner_info.Type + "']").attr('checked', 'checked');
              $(":radio[name='type_partner'][value='" + data.partner_info.TypePartner + "']").attr('checked',
                'checked');

              //INFO
              $("#kontak").val(data.partner_info.Contact);
              $("#alamat").val(data.partner_info.Address);
              $("#kota").val(data.partner_info.City);
              $("#negara").val(data.partner_info.Country);
              $("#fax").val(data.partner_info.Fax);
              $("#telex").val(data.partner_info.Telex);
              $("#no_pkp").val(data.partner_info.PKPNO);
              $("#tanggal_pkp").val(moment(data.partner_info.PKPDATE).format('DD MMMM YYYY'));
              $("#tanggal_pkp_real").val(data.partner_info.PKPDATE);
              $("#telepon").val(data.partner_info.Phone);
              $("#email").val(data.partner_info.Email);
              $("#website").val(data.partner_info.Website);
              $("#npwp").val(data.partner_info.NPWP);

              //ACCOUT
              $("#tempo_pembayaran").val(data.partner_info.Term);
              $("#mata_uang_ap").val(data.partner_info.Currency);
              $("#mata_uang_po").val(data.partner_info.CurrencyPO);
              $("#tipe_pembayaran").val(data.partner_info.PaymentType);
              $("#batas_kredit").val(currency(data.partner_info.CreditLimit));
              $(":radio[name='pajak_ppn'][value='" + data.partner_info.TipePPN + "']").attr('checked', 'checked');
              $("#masa_berlaku_po").val(data.partner_info.ExpiryDay);

              if (data.partner_shipment != null) {
                //SHIPMENT ADDRESS
                $("#id_pengiriman").val(data.partner_shipment.CustomerIDAlamat);
                $("#nama_penerima_pengiriman").val(data.partner_shipment.NamaPenerima);
                $("#alamat_pengiriman").val(data.partner_shipment.Alamat);
                $("#kota_pengiriman").val(data.partner_shipment.City);
                $("#kontak_pengiriman").val(data.partner_shipment.Contact);
                $("#telepon_pengiriman").val(data.partner_shipment.Phone);
                $("#note_pengiriman").val(data.partner_shipment.Keterangan);

                if (data.partner_shipment.Aktif == 1) {
                  $("#aktif_pengiriman").prop('checked', true);
                } else {
                  $("#aktif_pengiriman").prop('checked', false);
                }

                if (data.partner_shipment.Pajak == 1) {
                  $("#pajak_pengiriman").prop('checked', true);
                } else {
                  $("#pajak_pengiriman").prop('checked', false);
                }

                $("#connection_pengiriman").val(data.partner_shipment.Koneksi);
                $("#kode_lokasi_pengiriman").val(data.partner_shipment.KdLokasi);
                $("#kode_wilayah_pengiriman").val(data.partner_shipment.kdWilayah);
                $("#kode_cabang_pengiriman").val(data.partner_shipment.KdCabang);
                //$("#lokasi_cabang_pengiriman").html('-');
                //$("#kode_perusahaan_pengiriman_id").html();
              }

              $('#btn_edit_partner').prop("disabled", false);
            }
          },
          error: function(jqXHR, textStatus, errorThrown) {
            alert('Error when getting data');
          }
        });
      }
    }

    function openModal() {
      $('#modalForm').modal('show');
      $('#perusahaan').prop("disabled", false);
      $('#partner').prop("disabled", false);
      $('#revisi').prop("disabled", false);
    };

    document.addEventListener("DOMContentLoaded", function(event) {
      $("#loading-screen").hide();
      $("#informasi_tambahan").summernote({
        height: 150,
        toolbar: [
          ['style', ['style']],
          ['font', ['bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear']],
          ['fontname', ['fontname']],
          ['fontsize', ['fontsize']],
          ['color', ['color']],
          ['para', ['ol', 'ul', 'paragraph', 'height']],
          ['table', ['table']],
          ['insert', ['link']],
          ['view', ['undo', 'redo', 'fullscreen', 'codeview', 'help']]
        ]
      });

    });
  </script>
</body>

</html>