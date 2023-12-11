<?php
class Karyawan{
    public $id;
    public $nama;
    public $upah_per_jam;
    public $jam_kerja;
    public $jam_lembur;

    public function __construct($id, $nama, $upah_per_jam, $jam_kerja, $jam_lembur)
    {
        $this->id = $id;
        $this->nama = $nama;
        $this->upah_per_jam = $upah_per_jam;
        $this->jam_kerja = $jam_kerja;
        $this->jam_lembur = $jam_lembur;
    }

    public function hitungUpahLembur()
    {
        return $this->upah_per_jam * 1.15;}

    public function hitungGaji()
    {
        $gaji = ($this->jam_kerja * $this->upah_per_jam) + ($this->jam_lembur * $this->hitungUpahLembur());
        return $gaji;}
}
?>
