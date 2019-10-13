-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 14 Okt 2019 pada 00.06
-- Versi server: 10.1.35-MariaDB
-- Versi PHP: 7.2.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `e_learning`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`) VALUES
(1, 'admin', '79d2d87a347dabc58a774759cdac17013297dcd250af7131797a75346cb1ecfb18784e0a0a2ca2d15b08eeee300b39d2a4a611311a3457439c15975e8b92183dkKQNK+IodjEkQcgANoZxl6hHstONqGWp5Fed1DzETKE=');

-- --------------------------------------------------------

--
-- Struktur dari tabel `evaluasi`
--

CREATE TABLE `evaluasi` (
  `id` int(11) NOT NULL,
  `id_materi` int(11) NOT NULL,
  `soal` text NOT NULL,
  `jawaban_abc` int(11) DEFAULT NULL,
  `opsi_a` varchar(500) DEFAULT NULL,
  `opsi_b` varchar(500) DEFAULT NULL,
  `opsi_c` varchar(500) DEFAULT NULL,
  `opsi_d` varchar(500) DEFAULT NULL,
  `essay` text,
  `pembahasan` text NOT NULL,
  `type_jawaban` int(11) NOT NULL,
  `photo_soal` text,
  `photo_pembahasan` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `evaluasi`
--

INSERT INTO `evaluasi` (`id`, `id_materi`, `soal`, `jawaban_abc`, `opsi_a`, `opsi_b`, `opsi_c`, `opsi_d`, `essay`, `pembahasan`, `type_jawaban`, `photo_soal`, `photo_pembahasan`) VALUES
(1, 1, 'Mencoba Pertanyaan 1', 3, 'mencoba jawaban A', 'Mencoba Jawaban B', 'Mencoba jawaban C', 'mencoba jawaban D', 'Mencoba Essay', 'Mencoba Pembahasan', 1, NULL, NULL),
(2, 1, 'Mencoba Pertanyaan 2', 0, '', '', '', '', 'Mencoba Essay', 'Mencoba Pembahasan', 2, NULL, NULL),
(3, 2, 'Mencoba Pertanyaan ABC', 1, 'mencoba jawaban A', 'Mencoba Jawaban B', 'Mencoba jawaban C', 'mencoba jawaban D', NULL, 'Pembahasan mencoba ABC', 1, NULL, NULL),
(4, 3, 'Pertanyaan', 1, 'mencoba jawaban A', 'Mencoba Jawaban B', 'Mencoba jawaban C', 'mencoba jawaban D', NULL, 'Pembahasan', 1, NULL, NULL),
(5, 1, 'Pertanyaan apa saja kang? 3', 2, 'mencoba jawaban A', 'Mencoba Jawaban B', 'Mencoba jawaban C', 'mencoba jawaban D', '', 'Mencoba Pembahasan', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `kelas`
--

CREATE TABLE `kelas` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `kelas`
--

INSERT INTO `kelas` (`id`, `name`) VALUES
(1, 'P44');

-- --------------------------------------------------------

--
-- Struktur dari tabel `materi`
--

CREATE TABLE `materi` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `text` text NOT NULL,
  `photo_materi` text,
  `video_materi` varchar(255) DEFAULT NULL,
  `duration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `materi`
--

INSERT INTO `materi` (`id`, `name`, `text`, `photo_materi`, `video_materi`, `duration`) VALUES
(1, 'BAB I', '<ul>\r\n<li>Diagram use case</li>\r\n</ul>\r\n<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Menurut (Maimunah 2010), &ldquo;<em>Use case</em> adalah deksripsi fungsi dari sebuah sistem dari perspektif pengguna&rdquo;.&nbsp;<em>Use case</em>&nbsp;bekerja dengan cara mendeskripsikan tipikal interaksi antara pengguna sebuah sistem (aktor) dengan sistemnya sendiri melalui sebuah cerita bagaimana sebuah sistem dipakai.</p>\r\n<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Use<em>&nbsp;</em><em>case</em>&nbsp;<em>diagram</em>&nbsp;secara grafis menggambarkan interaksi antara sistem, sistem eksternal dan pengguna. Dengan kata lain&nbsp;<em>use case</em>&nbsp;<em>diagram</em>&nbsp;secara grafis mendeskripsikan siapa yang akan menggunakan sistem dan dalam cara apa pengguna (<em>user</em>) mengharapkan interaksi dengan sistem itu.&nbsp;<em>Use case</em>&nbsp;secara naratif digunakan untuk secara tekstual menggambarkan sekuensi langkah-langkah dari setiap interaksi (Maimunah 2010).</p>\r\n<p><a name=\"_Toc472954937\"></a>Tabel 2. 1 Simbol-Simbol Diagram Use Case.</p>\r\n<table border=\"2\" width=\"501\">\r\n<thead>\r\n<tr>\r\n<td width=\"46\">\r\n<p><strong>NO</strong></p>\r\n</td>\r\n<td width=\"95\">\r\n<p><strong>GAMBAR</strong></p>\r\n</td>\r\n<td width=\"118\">\r\n<p><strong>NAMA</strong></p>\r\n</td>\r\n<td width=\"242\">\r\n<p><strong>KETERANGAN</strong></p>\r\n</td>\r\n</tr>\r\n</thead>\r\n<tbody>\r\n<tr>\r\n<td width=\"46\">\r\n<p>1</p>\r\n</td>\r\n<td width=\"95\">\r\n<p>&nbsp;</p>\r\n</td>\r\n<td width=\"118\">\r\n<p><em>Actor</em></p>\r\n</td>\r\n<td width=\"242\">\r\n<p>Menspesifikasikan himpuan peran yang pengguna mainkan ketika berinteraksi dengan <em>use case</em>.</p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td width=\"46\">\r\n<p>2</p>\r\n</td>\r\n<td width=\"95\">&nbsp;</td>\r\n<td width=\"118\">\r\n<p><em>Dependency</em></p>\r\n</td>\r\n<td width=\"242\">\r\n<p>Hubungan dimana perubahan yang terjadi pada suatu elemen&nbsp; mandiri <em>(independent)</em> akan mempengaruhi elemen yang bergantung padanya elemen yang tidak mandiri.</p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td width=\"46\">\r\n<p>3</p>\r\n</td>\r\n<td width=\"95\">&nbsp;</td>\r\n<td width=\"118\">\r\n<p><em>Generalization</em></p>\r\n</td>\r\n<td width=\"242\">\r\n<p>Hubungan dimana objek anak (<em>descendent</em>) berbagi perilaku dan struktur data dari objek yang ada di atasnya objek induk (<em>ancestor</em>).</p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td width=\"46\">\r\n<p>4</p>\r\n</td>\r\n<td width=\"95\">&nbsp;</td>\r\n<td width=\"118\">\r\n<p><em>Include</em></p>\r\n</td>\r\n<td width=\"242\">\r\n<p>Menspesifikasikan bahwa <em>use case</em> sumber secara <em>eksplisit</em>.</p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td width=\"46\">\r\n<p>5</p>\r\n</td>\r\n<td width=\"95\">&nbsp;</td>\r\n<td width=\"118\">\r\n<p><em>Extend</em></p>\r\n</td>\r\n<td width=\"242\">\r\n<p>Menspesifikasikan bahwa <em>use case</em> target memperluas perilaku dari <em>use case</em> sumber pada suatu titik yang diberikan.</p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td width=\"46\">\r\n<p>6</p>\r\n</td>\r\n<td width=\"95\">&nbsp;</td>\r\n<td width=\"118\">\r\n<p><em>Association</em></p>\r\n</td>\r\n<td width=\"242\">\r\n<p>Apa yang menghubungkan antara objek satu dengan objek lainnya.</p>\r\n<p>&nbsp;</p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td width=\"46\">\r\n<p>7</p>\r\n</td>\r\n<td width=\"95\">&nbsp;</td>\r\n<td width=\"118\">\r\n<p><em>Use Case</em></p>\r\n</td>\r\n<td width=\"242\">\r\n<p>Deskripsi dari urutan aksi-aksi yang ditampilkan sistem yang menghasilkan suatu hasil yang terukur bagi suatu aktor</p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td width=\"46\">\r\n<p>8</p>\r\n</td>\r\n<td width=\"95\">&nbsp;</td>\r\n<td width=\"118\">\r\n<p><em>Collaboration</em></p>\r\n</td>\r\n<td width=\"242\">\r\n<p>Interaksi aturan-aturan dan elemen lain yang bekerja sama untuk menyediakan prilaku yang lebih besar dari jumlah dan elemen-elemennya (sinergi).</p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td width=\"46\">\r\n<p>9</p>\r\n</td>\r\n<td width=\"95\">&nbsp;</td>\r\n<td width=\"118\">\r\n<p><em>Note</em></p>\r\n</td>\r\n<td width=\"242\">\r\n<p>Elemen fisik yang eksis saat aplikasi dijalankan dan mencerminkan suatu sumber daya komputasi</p>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n<p>&nbsp;</p>\r\n<p>&nbsp;</p>', '789550df15a5944102b88e81eaa67802.jpg', 'e1f70a787a8a5b80e7598d5827d02e29.avi', 1),
(2, 'BAB II', '', NULL, '', 15),
(3, 'BAB III', '', NULL, '', 15),
(4, 'BAB IV', '', NULL, '', 15);

-- --------------------------------------------------------

--
-- Struktur dari tabel `nilai`
--

CREATE TABLE `nilai` (
  `id` int(11) NOT NULL,
  `id_kelas` int(11) NOT NULL,
  `id_mahasiswa` int(11) NOT NULL,
  `nilai_bab_1` int(11) NOT NULL,
  `nilai_bab_2` int(11) NOT NULL,
  `nilai_bab_3` int(11) NOT NULL,
  `nilai_bab_4` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `nilai`
--

INSERT INTO `nilai` (`id`, `id_kelas`, `id_mahasiswa`, `nilai_bab_1`, `nilai_bab_2`, `nilai_bab_3`, `nilai_bab_4`) VALUES
(2, 1, 1, 66, 0, 0, 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `id_kelas` int(11) NOT NULL,
  `nim` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id`, `id_kelas`, `nim`, `name`, `password`) VALUES
(1, 1, '1234', 'arjunane', '8a1060a2c4504d2d31da4b0cbe38ac553e5149d9739038de4584f8340e1a96e494ae6622809a0c1dee4ec6282ce3be7707355741c6affe6a5ff01e5d373c45faMgOb7TuaXtSLCKQ5Tz9TG7UlqphkAdq/12lUHbAo1Vg=');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `evaluasi`
--
ALTER TABLE `evaluasi`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `kelas`
--
ALTER TABLE `kelas`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `materi`
--
ALTER TABLE `materi`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `nilai`
--
ALTER TABLE `nilai`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `evaluasi`
--
ALTER TABLE `evaluasi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `kelas`
--
ALTER TABLE `kelas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `materi`
--
ALTER TABLE `materi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `nilai`
--
ALTER TABLE `nilai`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
