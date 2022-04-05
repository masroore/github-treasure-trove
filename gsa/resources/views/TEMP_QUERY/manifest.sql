select 
  `m`.`id` AS `id`, 
  `m`.`kode` AS `kode`, 
  `m`.`id_kota_asal` AS `id_kota_asal`, 
  `m`.`id_kota_tujuan` AS `id_kota_tujuan`, 
  `m`.`tanggal_pengiriman` AS `tanggal_pengiriman`, 
  `m`.`dicek_oleh` AS `dicek_oleh`, 
  `m`.`supir` AS `supir`, 
  `m`.`id_agen_penerima` AS `id_agen_penerima`, 
  `m`.`jumlah_kg` AS `jumlah_kg`, 
  `m`.`jumlah_koli` AS `jumlah_koli`, 
  `m`.`keterangan` AS `keterangan`, 
  `m`.`created_at` AS `created_at`, 
  `m`.`created_by` AS `created_by`, 
  `m`.`deleted_at` AS `deleted_at`, 
  `m`.`updated_at` AS `updated_at`, 
  `m`.`updated_by` AS `updated_by`, 
  `m`.`status` AS `status`, 
  `m`.`dibuat_oleh` AS `dibuat_oleh`, 
  `m`.`jumlah_doc` AS `jumlah_doc`, 
  `m`.`tanggal_diterima` AS `tanggal_diterima`, 
  `m`.`discan_terima_oleh` AS `discan_terima_oleh`, 
  `m`.`discan_diterima_oleh_nama` AS `discan_diterima_oleh_nama`, 
  `ka`.`nama` AS `kota_asal`, 
  `ktn`.`nama` AS `kota_tujuan`, 
  `u`.`nama` AS `dibuat_oleh_user` 
from 
  (
    (
      (
        `globalse_gsa`.`manifest` `m` 
        left join `globalse_gsa`.`kota` `ka` on(`ka`.`id` = `m`.`id_kota_asal`)
      ) 
      left join `globalse_gsa`.`kota` `ktn` on(
        `ktn`.`id` = `m`.`id_kota_tujuan`
      )
    ) 
    left join `globalse_gsa`.`users` `u` on(`u`.`id` = `m`.`dibuat_oleh`)
  ) 
where 
  `m`.`id` > 0
