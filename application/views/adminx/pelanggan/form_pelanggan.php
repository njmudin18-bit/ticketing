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
  <link rel="shortcut icon"
    href="<?php echo base_url(); ?>upload/general_images/<?php echo $perusahaan->icon_name; ?>" />
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
  </style>
  <!-- END SETTINGS -->
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
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
                <div class="card-body">
                  <div class="container">
                    <div class="row">
                      <div class="col-md-12 col-sm-12">
                        <h4 class="text-center">
                          <?php echo $nama_halaman; ?>
                          <span class="button-pilih">
                            <button type="button" class="btn btn-primary text-white btn-show-partner"
                              onclick="openModal();">
                              <i class="align-middle me-1" data-feather="plus-circle"></i>
                              Show Partner
                            </button>
                          </span>
                        </h4>
                      </div>
                    </div>
                    <hr>
                    <!-- PARTNER -->
                    <div class="row">
                      <div class="col-md-3">
                        <p class="fw-bold">Partner ID <span class="pull-right">:</span></p>
                      </div>
                      <div class="col-md-9">
                        <p id="partner_id">-</p>
                      </div>

                      <div class="col-md-3">
                        <p class="fw-bold">Partner Name <span class="pull-right">:</span></p>
                      </div>
                      <div class="col-md-9">
                        <p id="partner_name">-</p>
                      </div>

                      <div class="col-md-3">
                        <p class="fw-bold">Company Type <span class="pull-right">:</span></p>
                      </div>
                      <div class="col-md-9">
                        <div class="row mb-3">
                          <div class="col-md-3">
                            <label class="form-label me-4">
                              <input type="radio" id="company_type" name="company_type" value="-"
                                class="form-check-input" disabled>
                              <span class="form-check-label ms-1">-</span>
                            </label>
                          </div>
                          <div class="col-md-3">
                            <label class="form-label me-4">
                              <input type="radio" id="company_type" name="company_type" value="CV"
                                class="form-check-input" disabled>
                              <span class="form-check-label ms-1">CV</span>
                            </label>
                          </div>
                          <div class="col-md-3">
                            <label class="form-label me-4">
                              <input type="radio" id="company_type" name="company_type" value="FA"
                                class="form-check-input" disabled>
                              <span class="form-check-label ms-1">FA</span>
                            </label>
                          </div>
                          <div class="col-md-3">
                            <label class="form-label me-4">
                              <input type="radio" id="company_type" name="company_type" value="PD"
                                class="form-check-input" disabled>
                              <span class="form-check-label ms-1">PD</span>
                            </label>
                          </div>
                          <div class="col-md-3">
                            <label class="form-label me-4">
                              <input type="radio" id="company_type" name="company_type" value="PT"
                                class="form-check-input" disabled>
                              <span class="form-check-label ms-1">PT</span>
                            </label>
                          </div>
                          <div class="col-md-3">
                            <label class="form-label me-4">
                              <input type="radio" id="company_type" name="company_type" value="TOKO"
                                class="form-check-input" disabled>
                              <span class="form-check-label ms-1">TOKO</span>
                            </label>
                          </div>
                          <div class="col-md-3">
                            <label class="form-label me-4">
                              <input type="radio" id="company_type" name="company_type" value="UD"
                                class="form-check-input" disabled>
                              <span class="form-check-label ms-1">UD</span>
                            </label>
                          </div>
                        </div>
                      </div>

                      <div class="col-md-3">
                        <p class="fw-bold">Type Partner <span class="pull-right">:</span></p>
                      </div>
                      <div class="col-md-9">
                        <div class="row">
                          <div class="col-md-3">
                            <label class="form-label me-4">
                              <input type="radio" id="type_partner" name="type_partner" value="C"
                                class="form-check-input" disabled>
                              <span class="form-check-label ms-1">Pelanggan</span>
                            </label>
                          </div>
                          <div class="col-md-3">
                            <label class="form-label me-4">
                              <input type="radio" id="type_partner" name="type_partner" value="S"
                                class="form-check-input" disabled>
                              <span class="form-check-label ms-1">Pemasok</span>
                            </label>
                          </div>
                          <div class="col-md-6">
                            <label class="form-label me-4">
                              <input type="radio" id="type_partner" name="type_partner" value="A"
                                class="form-check-input" disabled>
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
                        <p class="fw-bold">Kontak <span class="pull-right">:</span></p>
                      </div>
                      <div class="col-md-9">
                        <p id="kontak">-</p>
                      </div>

                      <div class="col-md-3">
                        <p class="fw-bold">Alamat <span class="pull-right">:</span></p>
                      </div>
                      <div class="col-md-9">
                        <p id="alamat">-</p>
                      </div>

                      <div class="col-md-3">
                        <p class="fw-bold">Kota <span class="pull-right">:</span></p>
                      </div>
                      <div class="col-md-3">
                        <p id="kota">-</p>
                      </div>
                      <div class="col-md-3">
                        <p class="fw-bold">Negara <span class="pull-right">:</span></p>
                      </div>
                      <div class="col-md-3">
                        <p id="negara">-</p>
                      </div>

                      <div class="col-md-3">
                        <p class="fw-bold">Fax <span class="pull-right">:</span></p>
                      </div>
                      <div class="col-md-3">
                        <p id="fax">-</p>
                      </div>
                      <div class="col-md-3">
                        <p class="fw-bold">Telex <span class="pull-right">:</span></p>
                      </div>
                      <div class="col-md-3">
                        <p id="telex">-</p>
                      </div>

                      <div class="col-md-3">
                        <p class="fw-bold">No PKP <span class="pull-right">:</span></p>
                      </div>
                      <div class="col-md-3">
                        <p id="no_pkp">-</p>
                      </div>
                      <div class="col-md-3">
                        <p class="fw-bold">Tanggal PKP <span class="pull-right">:</span></p>
                      </div>
                      <div class="col-md-3">
                        <p id="tanggal_pkp">-</p>
                      </div>

                      <div class="col-md-3">
                        <p class="fw-bold">Telepon <span class="pull-right">:</span></p>
                      </div>
                      <div class="col-md-3">
                        <p id="telepon">-</p>
                      </div>
                      <div class="col-md-3">
                        <p class="fw-bold">Email <span class="pull-right">:</span></p>
                      </div>
                      <div class="col-md-3">
                        <p id="email">-</p>
                      </div>

                      <div class="col-md-3">
                        <p class="fw-bold">Website <span class="pull-right">:</span></p>
                      </div>
                      <div class="col-md-3">
                        <p id="website">-</p>
                      </div>
                      <div class="col-md-3">
                        <p class="fw-bold">NPWP <span class="pull-right">:</span></p>
                      </div>
                      <div class="col-md-3">
                        <p id="npwp">-</p>
                      </div>

                    </div>
                    <hr>
                    <!-- ACCOUNT -->
                    <div class="row">
                      <div class="col-md-12 mb-3">
                        <h4><strong>ACCOUNT</strong></h4>
                      </div>

                      <div class="col-md-3">
                        <p class="fw-bold">Tempo Pembayaran <span class="pull-right">:</span></p>
                      </div>
                      <div class="col-md-9">
                        <p><span id="tempo_pembayaran">-</span> Day(s)</p>
                      </div>

                      <div class="col-md-3">
                        <p class="fw-bold">Mata Uang AP <span class="pull-right">:</span></p>
                      </div>
                      <div class="col-md-9">
                        <p id="mata_uang_ap">-</p>
                      </div>

                      <div class="col-md-3">
                        <p class="fw-bold">Mata Uang PO <span class="pull-right">:</span></p>
                      </div>
                      <div class="col-md-9">
                        <p id="mata_uang_po">-</p>
                      </div>

                      <div class="col-md-3">
                        <p class="fw-bold">Tipe Pembayaran <span class="pull-right">:</span></p>
                      </div>
                      <div class="col-md-9">
                        <p id="tipe_pembayaran">T/T</p>
                      </div>

                      <div class="col-md-3">
                        <p class="fw-bold">Batas Kredit <span class="pull-right">:</span></p>
                      </div>
                      <div class="col-md-9">
                        <p id="batas_kredit">-</p>
                      </div>

                      <div class="col-md-3">
                        <p class="fw-bold">Pajak PPN <span class="pull-right">:</span></p>
                      </div>
                      <div class="col-md-9">
                        <div class="row mb-3">
                          <div class="col-md-3">
                            <label class="form-label me-4">
                              <input type="radio" id="pajak_ppn" name="pajak_ppn" value="N" class="form-check-input"
                                disabled>
                              <span class="form-check-label ms-1">None</span>
                            </label>
                          </div>
                          <div class="col-md-3">
                            <label class="form-label me-4">
                              <input type="radio" id="pajak_ppn" name="pajak_ppn" value="I" class="form-check-input"
                                disabled>
                              <span class="form-check-label ms-1">Include</span>
                            </label>
                          </div>
                          <div class="col-md-6">
                            <label class="form-label me-4">
                              <input type="radio" id="pajak_ppn" name="pajak_ppn" value="E" class="form-check-input"
                                disabled>
                              <span class="form-check-label ms-1">Exclude</span>
                            </label>
                          </div>
                        </div>
                      </div>

                      <div class="col-md-3">
                        <p class="fw-bold">Masa Berlaku PO <span class="pull-right">:</span></p>
                      </div>
                      <div class="col-md-9">
                        <p><span id="masa_berlaku_po">-</span> Day(s) from SO Date</p>
                      </div>
                    </div>
                    <hr>
                    <!-- SHIPMENT ADDRESS -->
                    <div class="row">
                      <div class="col-md-12 mb-3">
                        <h4><strong>SHIPMENT ADDRESS</strong></h4>
                      </div>

                      <div class="col-md-3">
                        <p class="fw-bold">ID Pengiriman <span class="pull-right">:</span></p>
                      </div>
                      <div class="col-md-9">
                        <p id="id_pengiriman">-</p>
                      </div>

                      <div class="col-md-3">
                        <p class="fw-bold">Nama Penerima <span class="pull-right">:</span></p>
                      </div>
                      <div class="col-md-9">
                        <p id="nama_penerima_pengiriman">-</p>
                      </div>

                      <div class="col-md-3">
                        <p class="fw-bold">Alamat Pengiriman <span class="pull-right">:</span></p>
                      </div>
                      <div class="col-md-9">
                        <p id="alamat_pengiriman">-</p>
                      </div>

                      <div class="col-md-3">
                        <p class="fw-bold">Kota <span class="pull-right">:</span></p>
                      </div>
                      <div class="col-md-9">
                        <p id="kota_pengiriman">-</p>
                      </div>

                      <div class="col-md-3">
                        <p class="fw-bold">Kontak <span class="pull-right">:</span></p>
                      </div>
                      <div class="col-md-3">
                        <p id="kontak_pengiriman">-</p>
                      </div>
                      <div class="col-md-3">
                        <p class="fw-bold">Telepon <span class="pull-right">:</span></p>
                      </div>
                      <div class="col-md-3">
                        <p id="telepon_pengiriman">-</p>
                      </div>

                      <div class="col-md-3">
                        <p class="fw-bold">Note <span class="pull-right">:</span></p>
                      </div>
                      <div class="col-md-3">
                        <p id="note_pengiriman">-</p>
                      </div>
                      <div class="col-md-3">
                        <p class="fw-bold">Aktif <span class="pull-right">:</span></p>
                      </div>
                      <div class="col-md-3">
                        <p id="aktif_pengiriman_id">
                          <input type="checkbox" name="aktif_pengiriman" id="aktif_pengiriman" class="form-check-input"
                            disabled>
                        </p>
                      </div>

                      <div class="col-md-3">
                        <p class="fw-bold">Pajak <span class="pull-right">:</span></p>
                      </div>
                      <div class="col-md-3">
                        <p id="pajak_pengiriman_id">
                          <input type="checkbox" name="pajak_pengiriman" id="pajak_pengiriman" class="form-check-input"
                            disabled>
                        </p>
                      </div>
                      <div class="col-md-3">
                        <p class="fw-bold">Connection <span class="pull-right">:</span></p>
                      </div>
                      <div class="col-md-3">
                        <p id="connection_pengiriman">-</p>
                      </div>

                      <div class="col-md-3">
                        <p class="fw-bold">Kode Lokasi <span class="pull-right">:</span></p>
                      </div>
                      <div class="col-md-3">
                        <p id="kode_lokasi_pengiriman">-</p>
                      </div>
                      <div class="col-md-3">
                        <p class="fw-bold">Kode Wilayah <span class="pull-right">:</span></p>
                      </div>
                      <div class="col-md-3">
                        <p id="kode_wilayah_pengiriman">-</p>
                      </div>

                      <div class="col-md-3">
                        <p class="fw-bold">Kode Cabang <span class="pull-right">:</span></p>
                      </div>
                      <div class="col-md-9">
                        <p id="kode_cabang_pengiriman">-</p>
                      </div>

                      <div class="col-md-3">
                        <p class="fw-bold">Lokasi Cabang <span class="pull-right">:</span></p>
                      </div>
                      <div class="col-md-9">
                        <p id="lokasi_cabang_pengiriman">-</p>
                      </div>

                      <div class="col-md-3">
                        <p class="fw-bold">Kode Perusahaan <span class="pull-right">:</span></p>
                      </div>
                      <div class="col-md-9">
                        <p id="kode_perusahaan_pengiriman_id">
                          <input type="checkbox" name="kode_perusahaan_pengiriman" id="kode_perusahaan_pengiriman"
                            class="form-check-input" disabled>
                        </p>
                      </div>
                    </div>
                    <hr>
                    <!-- LAMPIRAN DOKUMEN -->
                    <div class="row">
                      <div class="col-md-12 mb-3">
                        <h4><strong>LAMPIRAN KELENGKAPAN DOKUMEN</strong></h4>
                      </div>

                      <div class="col-md-2">
                        <label class="form-label me-4">
                          <input type="checkbox" id="npwp_doc" name="npwp_doc" class="form-check-input">
                          <span class="form-check-label ms-1">NPWP</span>
                        </label>
                      </div>
                      <div class="col-md-2">
                        <label class="form-label me-4">
                          <input type="checkbox" id="nib_doc" name="nib_doc" class="form-check-input">
                          <span class="form-check-label ms-1">NIB</span>
                        </label>
                      </div>
                      <div class="col-md-2">
                        <label class="form-label me-4">
                          <input type="checkbox" id="tdp_doc" name="tdp_doc" class="form-check-input">
                          <span class="form-check-label ms-1">TDP</span>
                        </label>
                      </div>
                      <div class="col-md-2">
                        <label class="form-label me-4">
                          <input type="checkbox" id="spkp_doc" name="spkp_doc" class="form-check-input">
                          <span class="form-check-label ms-1">SPPKP</span>
                        </label>
                      </div>
                      <div class="col-md-4">
                        <label class="form-label me-4">
                          <input type="checkbox" id="ktp_directur_doc" name="ktp_directur_doc" class="form-check-input">
                          <span class="form-check-label ms-1">KTP Direktur</span>
                        </label>
                      </div>
                      <div class="col-md-6">
                        <label class="form-label me-4">
                          <input type="checkbox" id="ktp_directur_doc" name="ktp_directur_doc" class="form-check-input">
                          <span class="form-check-label ms-1">Spesimen Nama dan TTD di PO</span>
                        </label>
                      </div>
                    </div>
                    <hr>
                    <!-- TANDA TANGAN -->
                    <div class="row">
                      <div class="col-md-12 mb-3">
                        <h4><strong>TANDA TANGAN</strong></h4>
                      </div>

                      <div class="col-md-3 text-center">
                        <p class="mb-6">Dibuat oleh</p>
                        <p class="mb-2">Erik Wijaya</p>
                        <p>DEPT. SALES</p>
                      </div>

                      <div class="col-md-3 text-center">
                        <p class="mb-6">Diperiksa oleh</p>
                        <p class="mb-2">Vicky Y</p>
                        <p>DEPT. ACCOUNTING</p>
                      </div>

                      <div class="col-md-3 text-center">
                        <p class="mb-6">Disetujui oleh</p>
                        <p class="mb-2">Djoe Sik Tjhan</p>
                        <p>DIRECTOR</p>
                      </div>

                      <div class="col-md-3 text-center">
                        <p class="mb-6">Dikerjakan oleh</p>
                        <p class="mb-2"><?php echo $this->session->userdata('user_realName'); ?></p>
                        <p>DEPT. IT</p>
                      </div>
                    </div>
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
  <div class="modal fade" id="modalForm" role="dialog" aria-hidden="true" data-bs-backdrop="static"
    data-bs-keyboard="false">
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
                <select id="perusahaan" name="perusahaan" class="form-select">
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
                <select id="partner" name="partner" class="form-select pilih-partner" required="required" width="100%">
                  <option selected="selected" disabled="disabled">-- Pilih --</option>
                  <?php foreach ($partner_all as $key => $value) : ?>
                  <option value="<?php echo $value->PartnerID; ?>">
                    <?php echo $value->PartnerID . " - " . $value->PartnerName; ?></option>
                  <?php endforeach ?>
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
  <script>
  function currency(price) {
    //let prices = new Intl.NumberFormat().format(price);
    let prices = new Intl.NumberFormat('de-DE', {
      minimumFractionDigits: 2,
      maximumFractionDigits: 2
    }).format(price);

    return prices;
  }

  function terapkan() {
    var perusahaan = $("#perusahaan").val();
    var partner = $("#partner").val();

    if (perusahaan == null || perusahaan == '') {
      alert('Perusahaan harus dipilih!');
      $("#perusahaan").focus();

      return false;
    } else if (partner == null || partner == '') {
      alert('Partner harus dipilih!');
      $("#partner").focus();

      return false;
    } else {
      $.ajax({
        url: "<?php echo base_url(); ?>pelanggan/get_partner",
        method: "POST",
        data: {
          partner_id: partner
        },
        dataType: 'json',
        success: function(data) {
          if (data.status_code == 200) {
            $('#modalForm').modal('hide');
            //$('#terapkanForm')[0].reset();

            //SET TO VIEW
            $("#partner_id").html(data.partner_info.PartnerID);
            $("#partner_name").html(data.partner_info.PartnerName);
            $(":radio[name='company_type'][value='" + data.partner_info.Type + "']").attr('checked', 'checked');
            $(":radio[name='type_partner'][value='" + data.partner_info.TypePartner + "']").attr('checked',
              'checked');

            //INFO
            $("#kontak").html(data.partner_info.Contact);
            $("#alamat").html(data.partner_info.Address);
            $("#kota").html(data.partner_info.City);
            $("#negara").html(data.partner_info.Country);
            $("#fax").html(data.partner_info.Fax);
            $("#telex").html(data.partner_info.Telex);
            $("#no_pkp").html(data.partner_info.PKPNO);
            $("#tanggal_pkp").html(moment(data.partner_info.PKPDATE).format('DD MMMM YYYY'));
            $("#telepon").html(data.partner_info.Phone);
            $("#email").html(data.partner_info.Email);
            $("#website").html(data.partner_info.Website);
            $("#npwp").html(data.partner_info.NPWP);

            //ACCOUT
            $("#tempo_pembayaran").html(data.partner_info.Term);
            $("#mata_uang_ap").html(data.partner_info.Currency);
            $("#mata_uang_po").html(data.partner_info.CurrencyPO);
            $("#tipe_pembayaran").html(data.partner_info.PaymentType);
            $("#batas_kredit").html(currency(data.partner_info.CreditLimit));
            $(":radio[name='pajak_ppn'][value='" + data.partner_info.TipePPN + "']").attr('checked', 'checked');
            $("#masa_berlaku_po").html(data.partner_info.ExpiryDay);

            //SHIPMENT ADDRESS
            $("#id_pengiriman").html(data.partner_shipment.CustomerIDAlamat);
            $("#nama_penerima_pengiriman").html(data.partner_shipment.NamaPenerima);
            $("#alamat_pengiriman").html(data.partner_shipment.Alamat);
            $("#kota_pengiriman").html(data.partner_shipment.City);
            $("#kontak_pengiriman").html(data.partner_shipment.Contact);
            $("#telepon_pengiriman").html(data.partner_shipment.Phone);
            $("#note_pengiriman").html(data.partner_shipment.Keterangan);

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

            $("#connection_pengiriman").html(data.partner_shipment.Koneksi);
            $("#kode_lokasi_pengiriman").html(data.partner_shipment.KdLokasi);
            $("#kode_wilayah_pengiriman").html(data.partner_shipment.kdWilayah);
            $("#kode_cabang_pengiriman").html(data.partner_shipment.KdCabang);
            //$("#lokasi_cabang_pengiriman").html('-');
            //$("#kode_perusahaan_pengiriman_id").html();
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
  };

  document.addEventListener("DOMContentLoaded", function(event) {
    $("#loading-screen").hide();

    console.log(moment().format('DD MMMM YYYY'));

    $(".pilih-partner").select2({
      width: '100%',
      dropdownParent: $("#modalForm")
    });


  });
  </script>
</body>

</html>