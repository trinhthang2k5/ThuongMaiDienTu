CREATE DATABASE tmdt;

use tmdt;

CREATE TABLE quan_tri(
id int PRIMARY KEY AUTO_INCREMENT,
Tai_khoan varchar(50) not null,
Mat_khau varchar(32)
);   

-- Tạo bảng tin_tuc
CREATE TABLE tin_tuc(
MaTT int not null PRIMARY KEY AUTO_INCREMENT,
Tieu_de varchar(200),
Noi_dung text,
Ngay_dang_tin datetime,
Hinh_anh varchar(50)
);   

-- Tạo bảng khach_hang
CREATE TABLE khach_hang(
MaKH int not null PRIMARY KEY AUTO_INCREMENT,
Ho_ten varchar(100) not null,
Dia_chi varchar(200),
Dien_thoai varchar(30),
Email varchar(50),
Gioi_tinh tinyint(4)
);

CREATE TABLE pt_van_chuyen (
MaPTVC int PRIMARY KEY AUTO_INCREMENT,
Ten_PTVC VARCHAR(50)
);

CREATE TABLE pt_thanh_toan (
MaPTTT int PRIMARY key AUTO_INCREMENT,
Ten_PTTT varchar(50)
);

CREATE TABLE loai_san_pham (
MaLSP int PRIMARY KEY AUTO_INCREMENT,
Ten_loai varchar(50)
);

CREATE TABLE san_pham (
MaSP int PRIMARY KEY AUTO_INCREMENT,
Ten_sp varchar(200),
Mo_ta varchar(250),
Thong_tin text, 
Gia_ban float,
Hinh_anh varchar(300),
So_luong int,
Ten_nhan_hieu varchar(50),
Ngay_cap_nhap timestamp,
Trang_thai tinyint(4),
MaLSP int,
FOREIGN KEY (MaLSP) REFERENCES loai_san_pham(MaLSP)
);

CREATE TABLE hoa_don (
MaHD int PRIMARY key AUTO_INCREMENT,
Ngayxuat_HD datetime,
Hoten_nguoinhan varchar(50),
Dia_chi_nguoinhan varchar(50),
Dienthoai_nguoinhan varchar(10),
Diachi_email varchar(50),
Ngay_giao_hang timestamp,
Trang_thai tinyint(4),
MaKH int,
FOREIGN KEY (MaKH) REFERENCES khach_hang(MaKH)
);

CREATE TABLE Nguoi_dung(
id int PRIMARY KEY AUTO_INCREMENT,
Tai_khoan varchar(50) not null,
Mat_khau varchar(32) not null
);

CREATE TABLE ct_hoa_don (
MaHD int,
FOREIGN KEY (MaHD) REFERENCES hoa_don(MaHD),
MaSP int,
FOREIGN KEY (MaSP) REFERENCES san_pham(MaSP),
MaPTVC int,
FOREIGN KEY (MaPTVC) REFERENCES pt_van_chuyen(MaPTVC),
MaPTTT int,
FOREIGN KEY (MaPTTT) REFERENCES pt_thanh_toan(MaPTTT),
So_luong int,
Gia_ban float
);

ALTER TABLE `hoa_don` CHANGE `Ngayxuat_HD` `Ngayxuat_HD` TIMESTAMP on update CURRENT_TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP;

INSERT INTO `quan_tri`(`Tai_khoan`, `Mat_khau`) VALUES 
('ThanhNV3005',MD5('12345')),
('ThangTV123',MD5('54321')),
('ThongTD456',MD5('56789')),
('Zedd12345',MD5('98765')),
('TTT789',MD5('00000'));

INSERT INTO `tin_tuc`(`Tieu_de`,`Noi_dung`, `Ngay_dang_tin`, `Hinh_anh`) VALUES 
('Hàng Quảng Châu','Đồ dùng nhà bếp','2023-03-04','Ảnh 1'),
('Đồ dành cho trẻ em','Lego','2023-04-05','Ảnh 2'),
('Hàng Châu Âu','Phụ kiện thể thao','2023-05-06','Ảnh 3'),
('Đồ hiệu','Váy','2023-06-07','Ảnh 4'),
('Hàng USA','Máy tính','2023-07-08','Ảnh 5');

INSERT INTO `khach_hang`(`Ho_ten`, `Dia_chi`, `Dien_thoai`, `Email`, `Gioi_tinh`) VALUES
('Trần Thị Vân','Hà Nội',0987654321,'Toan1@gmail.com',0),
('Nguyễn Tuấn Anh','Hà Nam',0987654123,'NTA2@gmail.com',1),
('Trịnh Văn Thông','Vĩnh Phúc',0987651234,'ThongTV3@gmail.com',1),
('Nguyễn Đức Thắng','Hải Phòng',0987612345,'ThangND4@gmail.com',1),
('Nguyễn Thị Hồng Ngọc','Lào Cai',0987123456,'ThuanBD5@gmail.com',0);

INSERT INTO `pt_van_chuyen`(`Ten_PTVC`) VALUES 
('Máy bay'),
('Ô tô'),
('Tàu hỏa'),
('Tàu thủy'),
('Trực Thăng');

INSERT INTO `pt_thanh_toan`( `Ten_PTTT`) VALUES 
('Thanh toán khi nhận hàng'),
('Ví VNPay'),
('Ví FPT'),
('Thẻ tín dụng'),
('Ứng dụng thanh toán di động');

INSERT INTO `loai_san_pham`( `Ten_loai`) VALUES 
('Thiết bị gia dụng'),
('Thiết bị điện tử'),
('Thể thao và du lịch'),
('Thời trang nam'),
('Thời trang nữ'),
('Thời trang trẻ em'),
('Mẹ và bé'),
('Đồ chơi'),
('Điện thoại và phụ kiện'),
('Nhà cửa và đời sống'),
('Máy tính và laptop'),
('Sắc đẹp'),
('Máy ảnh và máy quay phim'),
('Sức khỏe'),
('Đồng hồ'),
('Giày dép nữ'),
('Giày dép nam'),
('Túi ví nữ'),
('Phụ kiện và trang sức nữ'),
('Bách hóa Online'),
('Nhà sách Online'),
('Ô tô và xe máy và xe đạp'),
('Balo và túi ví nam'),
('Giặt giũ và chăm sóc nhà cửa'),
('Chăm sóc thú cưng'),
('Dụng cụ và thiết bị tiện ích'),
('Voucher và dịch vụ')
;

INSERT INTO `san_pham`(`Ten_sp`, `Mo_ta`, `Thong_tin`, `Gia_ban`,`Hinh_anh`,`So_luong`, `Ten_nhan_hieu`,`Trang_thai`, `MaLSP`) VALUES 
('Máy lọc nước Kangaroo Hydrogen chân quỳ KGRP10','2 chế độ nước RO – nước Hydrogen đa dạng nhu cầu','Thông tin 1',4250000,'Ảnh 1',2000,'Kangaroo',1,1),
('iPhone 15 Pro Max','Bảo hành 12 tháng chính hãng','Thông tin 2',41590000,'Ảnh 2',2000,'APPLE',1,5),
('GIÀY GOLF SAMBA','Sản phẩm này không được áp dụng cho mọi chương trình giảm giá và khuyến mại','Thông tin 3',3100000,'Ảnh 3',2000,'Adidas',1,3),
('KARL LAGERFELD Đầm Nữ','KARL LAGERFELD được lấy cùng tên với người sáng lập là ông Karl Lagerfeld – huyền thoại thời trang thế giới','Thông tin 4',8299000,'Ảnh 4',2000,'Chanel',1,2),
('Lego Technic Siêu Xe Mercedes-AMG F1 W14 E Performance 42171','Các tay đua gọi đó là khu vực','Thông tin 5',6890000,'Ảnh 5',2000,' LEGO',1,4);

INSERT INTO `hoa_don`( `Hoten_nguoinhan`, `Dia_chi_nguoinhan`, `Dienthoai_nguoinhan`, `Diachi_email`,`Trang_thai`, `MaKH`) VALUES 
('Trần Thị Vân','Hà Nội',0987654321,'Toan1@gmail.com',0,1),
('Nguyễn Tuấn Anh','Hà Nam ',0987654123,'NTA2@gmail.com',0,2),
('Trịnh Văn Thông','Vĩnh Phúc',0987651234,'ThongTV3@gmail.com',0,3),
('Nguyễn Đức Thắng','Hải Phòng',0987612345,'ThangND4@gmail.com',0,4),
('Nguyễn Thị Hồng Ngọc','Lào Cai',0987123456,'ThuanBD5@gmail.com',0,5);

INSERT INTO `ct_hoa_don`(`MaHD`,`MaSP`, `So_luong`, `Gia_ban`,`MaPTVC`,`MaPTTT`) VALUES 
(1,1,50,4250000,1,1),
(3,2,60,41590000,2,2),
(4,3,70,3100000,3,3),
(5,4,80,8299000,4,4),
(2,5,90,6890000,5,5);