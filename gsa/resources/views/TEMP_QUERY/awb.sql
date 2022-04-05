-- CREATE VIEW "view_report_awb" -------------------------------
CREATE ALGORITHM = UNDEFINED DEFINER = `globalse_gsa` @`%` SQL SECURITY DEFINER VIEW `view_report_awb` AS 
select 
  `a`.`id` AS `id`, 
  `a`.`noawb` AS `noawb`, 
  `a`.`id_customer` AS `id_customer`, 
  `a`.`id_kota_tujuan` AS `id_kota_tujuan`, 
  `a`.`id_kota_asal` AS `id_kota_asal`, 
  `a`.`id_kota_transit` AS `id_kota_transit`, 
  `a`.`id_agen_asal` AS `id_agen_asal`, 
  `a`.`id_agen_penerima` AS `id_agen_penerima`, 
  `a`.`charge_oa` AS `charge_oa`, 
  `a`.`alamat_tujuan` AS `alamat_tujuan`, 
  `a`.`notelp_penerima` AS `notelp_penerima`, 
  `a`.`nama_penerima` AS `nama_penerima`, 
  `a`.`nama_pengirim` AS `nama_pengirim`, 
  `a`.`keterangan` AS `keterangan`, 
  `a`.`total_harga` AS `total_harga`, 
  `a`.`tanggal_awb` AS `tanggal_awb`, 
  `a`.`created_at` AS `created_at`, 
  `a`.`created_by` AS `created_by`, 
  `a`.`deleted_at` AS `deleted_at`, 
  `a`.`updated_at` AS `updated_at`, 
  `a`.`updated_by` AS `updated_by`, 
  `a`.`status_invoice` AS `status_invoice`, 
  `a`.`status_tracking` AS `status_tracking`, 
  `a`.`status_manifest` AS `status_manifest`, 
  `a`.`status_paid_agen` AS `status_paid_agen`, 
  `a`.`qty_kecil` AS `qty_kecil`, 
  `a`.`qty_sedang` AS `qty_sedang`, 
  `a`.`qty_besar` AS `qty_besar`, 
  `a`.`qty_besarbanget` AS `qty_besarbanget`, 
  `a`.`qty_kg` AS `qty_kg`, 
  `a`.`qty_doc` AS `qty_doc`, 
  `a`.`qty` AS `qty`, 
  `a`.`kodepos_penerima` AS `kodepos_penerima`, 
  `a`.`idr_oa` AS `idr_oa`, 
  `a`.`id_manifest` AS `id_manifest`, 
  `a`.`id_invoice` AS `id_invoice`, 
  `a`.`kodepos_pengirim` AS `kodepos_pengirim`, 
  `a`.`alamat_pengirim` AS `alamat_pengirim`, 
  `a`.`notelp_pengirim` AS `notelp_pengirim`, 
  `a`.`id_kecamatan_tujuan` AS `id_kecamatan_tujuan`, 
  `a`.`tanggal_diterima` AS `tanggal_diterima`, 
  `a`.`diterima_oleh` AS `diterima_oleh`, 
  `a`.`is_agen` AS `is_agen`, 
  `a`.`ada_faktur` AS `ada_faktur`, 
  `a`.`referensi` AS `referensi`, 
  `a`.`jenis_koli` AS `jenis_koli`, 
  `a`.`labelalamat` AS `labelalamat`, 
  `ka`.`nama` AS `kota_asal`, 
  `ktt`.`nama` AS `kota_transit`, 
  `ktn`.`nama` AS `kota_tujuan`, 
  `al`.`nama` AS `agen_asal`, 
  `ap`.`nama` AS `agen_tujuan`, 
  `m`.`kode` AS `kode_manifest`, 
  `i`.`kode` AS `kode_invoice`, 
  `c`.`nama` AS `pengirim`, 
  `kc`.`nama` AS `kecamatan_tujuan` 
from 
  (
    (
      (
        (
          (
            (
              (
                (
                  (
                    `globalse_gsa`.`awb` `a` 
                    left join `globalse_gsa`.`kota` `ka` on(`ka`.`id` = `a`.`id_kota_asal`)
                  ) 
                  left join `globalse_gsa`.`kota` `ktt` on(
                    `ktt`.`id` = `a`.`id_kota_transit`
                  )
                ) 
                left join `globalse_gsa`.`kota` `ktn` on(
                  `ktn`.`id` = `a`.`id_kota_tujuan`
                )
              ) 
              left join `globalse_gsa`.`agen` `al` on(`al`.`id` = `a`.`id_agen_asal`)
            ) 
            left join `globalse_gsa`.`agen` `ap` on(
              `ap`.`id` = `a`.`id_agen_penerima`
            )
          ) 
          join `globalse_gsa`.`customer` `c` on(`c`.`id` = `a`.`id_customer`)
        ) 
        join `globalse_gsa`.`manifest` `m` on(`a`.`id_manifest` = `m`.`id`)
      ) 
      join `globalse_gsa`.`invoice` `i` on(`a`.`id_invoice` = `i`.`id`)
    ) 
    join `globalse_gsa`.`kecamatan` `kc` on(
      `kc`.`id` = `a`.`id_kecamatan_tujuan`
    )
  ) 
where 
  `a`.`id` > 0;
