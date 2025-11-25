<?php

namespace App\Services;

class LocationService
{
    private $kabupatenKota = [
        ['id' => '3519', 'name' => 'KABUPATEN MAGETAN']
    ];

    private $kecamatans = [
        ['id' => '3519010', 'kabupaten_id' => '3519', 'name' => 'PONCOL'],
        ['id' => '3519020', 'kabupaten_id' => '3519', 'name' => 'PARANG'],
        ['id' => '3519030', 'kabupaten_id' => '3519', 'name' => 'LEMBEYAN'],
        ['id' => '3519040', 'kabupaten_id' => '3519', 'name' => 'TAKERAN'],
        ['id' => '3519050', 'kabupaten_id' => '3519', 'name' => 'KAWEDANAN'],
        ['id' => '3519060', 'kabupaten_id' => '3519', 'name' => 'MAGETAN'],
        ['id' => '3519070', 'kabupaten_id' => '3519', 'name' => 'NGUNTORONADI'],
        ['id' => '3519080', 'kabupaten_id' => '3519', 'name' => 'SIDOREJO'],
        ['id' => '3519090', 'kabupaten_id' => '3519', 'name' => 'PANEKAN'],
        ['id' => '3519100', 'kabupaten_id' => '3519', 'name' => 'SUKOMORO'],
        ['id' => '3519110', 'kabupaten_id' => '3519', 'name' => 'BENDO'],
        ['id' => '3519120', 'kabupaten_id' => '3519', 'name' => 'MAOSPATI'],
        ['id' => '3519130', 'kabupaten_id' => '3519', 'name' => 'KARANGREJO'],
        ['id' => '3519140', 'kabupaten_id' => '3519', 'name' => 'KARAS'],
        ['id' => '3519150', 'kabupaten_id' => '3519', 'name' => 'BARAT'],
        ['id' => '3519160', 'kabupaten_id' => '3519', 'name' => 'KARTOHARJO'],
        ['id' => '3519170', 'kabupaten_id' => '3519', 'name' => 'NGARIBOYO'],
    ];

    private $kelurahans = [
        // Kecamatan Poncol (id: 3519010)
        ['id' => '3519010001', 'kecamatan_id' => '3519010', 'kode_pos' => '63362', 'name' => 'CILENG'],
        ['id' => '3519010002', 'kecamatan_id' => '3519010', 'kode_pos' => '63362', 'name' => 'GENILANGIT'],
        ['id' => '3519010003', 'kecamatan_id' => '3519010', 'kode_pos' => '63362', 'name' => 'GONGGANG'],
        ['id' => '3519010004', 'kecamatan_id' => '3519010', 'kode_pos' => '63362', 'name' => 'JANGGAN'],
        ['id' => '3519010005', 'kecamatan_id' => '3519010', 'kode_pos' => '63362', 'name' => 'PLANGKRONGAN'],
        ['id' => '3519010006', 'kecamatan_id' => '3519010', 'kode_pos' => '63362', 'name' => 'PONCOL'],
        ['id' => '3519010007', 'kecamatan_id' => '3519010', 'kode_pos' => '63362', 'name' => 'SOMBO'],
    
        // Kecamatan Parang (id: 3519020)
        ['id' => '3519020001', 'kecamatan_id' => '3519020', 'kode_pos' => '63371', 'name' => 'BUNGKUK'],
        ['id' => '3519020002', 'kecamatan_id' => '3519020', 'kode_pos' => '63371', 'name' => 'JOKETRO'],
        ['id' => '3519020003', 'kecamatan_id' => '3519020', 'kode_pos' => '63371', 'name' => 'KRAJAN'],
        ['id' => '3519020004', 'kecamatan_id' => '3519020', 'kode_pos' => '63371', 'name' => 'MATEGAL'],
        ['id' => '3519020005', 'kecamatan_id' => '3519020', 'kode_pos' => '63371', 'name' => 'NGAGLIK'],
        ['id' => '3519020006', 'kecamatan_id' => '3519020', 'kode_pos' => '63371', 'name' => 'NGLOPANG'],
        ['id' => '3519020007', 'kecamatan_id' => '3519020', 'kode_pos' => '63371', 'name' => 'NGUNUT'],
        ['id' => '3519020008', 'kecamatan_id' => '3519020', 'kode_pos' => '63371', 'name' => 'PRAGAK'],
        ['id' => '3519020009', 'kecamatan_id' => '3519020', 'kode_pos' => '63371', 'name' => 'SAYUTAN'],
        ['id' => '3519020010', 'kecamatan_id' => '3519020', 'kode_pos' => '63371', 'name' => 'SUNDUL'],
        ['id' => '3519020011', 'kecamatan_id' => '3519020', 'kode_pos' => '63371', 'name' => 'TROSONO'],
        ['id' => '3519020012', 'kecamatan_id' => '3519020', 'kode_pos' => '63371', 'name' => 'TAMANARUM'],
    
        // Kecamatan Lembeyan (id: 3519030)
        ['id' => '3519030001', 'kecamatan_id' => '3519030', 'kode_pos' => '63372', 'name' => 'DUKUH'],
        ['id' => '3519030002', 'kecamatan_id' => '3519030', 'kode_pos' => '63372', 'name' => 'KEDIREN'],
        ['id' => '3519030003', 'kecamatan_id' => '3519030', 'kode_pos' => '63372', 'name' => 'KEDUNGPANJI'],
        ['id' => '3519030004', 'kecamatan_id' => '3519030', 'kode_pos' => '63372', 'name' => 'KROWE'],
        ['id' => '3519030005', 'kecamatan_id' => '3519030', 'kode_pos' => '63372', 'name' => 'LEMBEYAN KULON'],
        ['id' => '3519030006', 'kecamatan_id' => '3519030', 'kode_pos' => '63372', 'name' => 'LEMBEYAN WETAN'],
        ['id' => '3519030007', 'kecamatan_id' => '3519030', 'kode_pos' => '63372', 'name' => 'NGURI'],
        ['id' => '3519030008', 'kecamatan_id' => '3519030', 'kode_pos' => '63372', 'name' => 'PUPUS'],
        ['id' => '3519030009', 'kecamatan_id' => '3519030', 'kode_pos' => '63372', 'name' => 'TAPEN'],
        ['id' => '3519030010', 'kecamatan_id' => '3519030', 'kode_pos' => '63372', 'name' => 'TUNGGUR'],
    
        // Kecamatan Takeran (id: 3519040)
        ['id' => '3519040001', 'kecamatan_id' => '3519040', 'kode_pos' => '63383', 'name' => 'DUYUNG'],
        ['id' => '3519040002', 'kecamatan_id' => '3519040', 'kode_pos' => '63383', 'name' => 'JOMBLANG'],
        ['id' => '3519040003', 'kecamatan_id' => '3519040', 'kode_pos' => '63383', 'name' => 'KEPUHREJO'],
        ['id' => '3519040004', 'kecamatan_id' => '3519040', 'kode_pos' => '63383', 'name' => 'KERANG'],
        ['id' => '3519040005', 'kecamatan_id' => '3519040', 'kode_pos' => '63383', 'name' => 'KERIK'],
        ['id' => '3519040006', 'kecamatan_id' => '3519040', 'kode_pos' => '63383', 'name' => 'KIRINGAN'],
        ['id' => '3519040007', 'kecamatan_id' => '3519040', 'kode_pos' => '63383', 'name' => 'KUWONHARJO'],
        ['id' => '3519040008', 'kecamatan_id' => '3519040', 'kode_pos' => '63383', 'name' => 'MADIGONDO'],
        ['id' => '3519040009', 'kecamatan_id' => '3519040', 'kode_pos' => '63383', 'name' => 'SAWOJAJAR'],
        ['id' => '3519040010', 'kecamatan_id' => '3519040', 'kode_pos' => '63383', 'name' => 'TAWANGREJO'],
        ['id' => '3519040011', 'kecamatan_id' => '3519040', 'kode_pos' => '63383', 'name' => 'WADUK'],
    
        // Kecamatan Kawedanan (id: 3519050)
        ['id' => '3519050001', 'kecamatan_id' => '3519050', 'kode_pos' => '63382', 'name' => 'BALEREJO'],
        ['id' => '3519050002', 'kecamatan_id' => '3519050', 'kode_pos' => '63382', 'name' => 'BOGEM'],
        ['id' => '3519050003', 'kecamatan_id' => '3519050', 'kode_pos' => '63382', 'name' => 'GARON'],
        ['id' => '3519050004', 'kecamatan_id' => '3519050', 'kode_pos' => '63382', 'name' => 'GENENGAN'],
        ['id' => '3519050005', 'kecamatan_id' => '3519050', 'kode_pos' => '63382', 'name' => 'GIRIPURNO'],
        ['id' => '3519050006', 'kecamatan_id' => '3519050', 'kode_pos' => '63382', 'name' => 'JAMBANGAN'],
        ['id' => '3519050007', 'kecamatan_id' => '3519050', 'kode_pos' => '63382', 'name' => 'KARANGREJO'],
        ['id' => '3519050008', 'kecamatan_id' => '3519050', 'kode_pos' => '63382', 'name' => 'KAWEDANAN'],
        ['id' => '3519050009', 'kecamatan_id' => '3519050', 'kode_pos' => '63382', 'name' => 'MANGUNREJO'],
        ['id' => '3519050010', 'kecamatan_id' => '3519050', 'kode_pos' => '63382', 'name' => 'MOJOREJO'],
        ['id' => '3519050011', 'kecamatan_id' => '3519050', 'kode_pos' => '63382', 'name' => 'NGADIREJO'],
        ['id' => '3519050012', 'kecamatan_id' => '3519050', 'kode_pos' => '63382', 'name' => 'NGENTEP'],
        ['id' => '3519050013', 'kecamatan_id' => '3519050', 'kode_pos' => '63382', 'name' => 'NGUNUT'],
        ['id' => '3519050014', 'kecamatan_id' => '3519050', 'kode_pos' => '63382', 'name' => 'POJOK'],
        ['id' => '3519050015', 'kecamatan_id' => '3519050', 'kode_pos' => '63382', 'name' => 'REJOSARI'],
        ['id' => '3519050016', 'kecamatan_id' => '3519050', 'kode_pos' => '63382', 'name' => 'SAMPUNG'],
        ['id' => '3519050017', 'kecamatan_id' => '3519050', 'kode_pos' => '63382', 'name' => 'SELOREJO'],
        ['id' => '3519050018', 'kecamatan_id' => '3519050', 'kode_pos' => '63382', 'name' => 'SUGIHREJO'],
        ['id' => '3519050019', 'kecamatan_id' => '3519050', 'kode_pos' => '63382', 'name' => 'TLADAN'],
        ['id' => '3519050020', 'kecamatan_id' => '3519050', 'kode_pos' => '63382', 'name' => 'TULUNG'],
    
        // Kecamatan MAGETAN (id: 3519060)
        ['id' => '3519060001', 'kecamatan_id' => '3519060', 'kode_pos' => '63311', 'name' => 'BARON'],
        ['id' => '3519060002', 'kecamatan_id' => '3519060', 'kode_pos' => '63311', 'name' => 'CANDIREJO'],
        ['id' => '3519060003', 'kecamatan_id' => '3519060', 'kode_pos' => '63312', 'name' => 'PURWOSARI'],
        ['id' => '3519060004', 'kecamatan_id' => '3519060', 'kode_pos' => '63313', 'name' => 'RINGINAGUNG'],
        ['id' => '3519060005', 'kecamatan_id' => '3519060', 'kode_pos' => '63314', 'name' => 'TAMBAKREJO'],
        ['id' => '3519060006', 'kecamatan_id' => '3519060', 'kode_pos' => '63315', 'name' => 'BULUKERTO'],
        ['id' => '3519060007', 'kecamatan_id' => '3519060', 'kode_pos' => '63316', 'name' => 'KEPOLOREJO'],
        ['id' => '3519060008', 'kecamatan_id' => '3519060', 'kode_pos' => '63317', 'name' => 'KEBONAGUNG'],
        ['id' => '3519060009', 'kecamatan_id' => '3519060', 'kode_pos' => '63318', 'name' => 'MAGETAN'],
        ['id' => '3519060010', 'kecamatan_id' => '3519060', 'kode_pos' => '63319', 'name' => 'MANGKUJAYAN'],
        ['id' => '3519060011', 'kecamatan_id' => '3519060', 'kode_pos' => '63319', 'name' => 'SELOSARI'],
        ['id' => '3519060012', 'kecamatan_id' => '3519060', 'kode_pos' => '63319', 'name' => 'SUKOWINANGUN'],
        ['id' => '3519060013', 'kecamatan_id' => '3519060', 'kode_pos' => '63319', 'name' => 'TAWANGANOM'],
        ['id' => '3519060014', 'kecamatan_id' => '3519060', 'kode_pos' => '63319', 'name' => 'TAMBRAN'],
    
        // Kecamatan NGUNTORONADI (id: 3519070)
        ['id' => '3519070001', 'kecamatan_id' => '3519070', 'kode_pos' => '63381', 'name' => 'DRIYOREJO'],
        ['id' => '3519070002', 'kecamatan_id' => '3519070', 'kode_pos' => '63381', 'name' => 'GORANG-GARENG'],
        ['id' => '3519070003', 'kecamatan_id' => '3519070', 'kode_pos' => '63381', 'name' => 'KENONGOMULYO'],
        ['id' => '3519070004', 'kecamatan_id' => '3519070', 'kode_pos' => '63381', 'name' => 'NGUNTORONADI'],
        ['id' => '3519070005', 'kecamatan_id' => '3519070', 'kode_pos' => '63381', 'name' => 'PETUNGREJO'],
        ['id' => '3519070006', 'kecamatan_id' => '3519070', 'kode_pos' => '63381', 'name' => 'PUROREJO'],
        ['id' => '3519070007', 'kecamatan_id' => '3519070', 'kode_pos' => '63381', 'name' => 'SEMEN'],
        ['id' => '3519070008', 'kecamatan_id' => '3519070', 'kode_pos' => '63381', 'name' => 'SIMBATAN'],
        ['id' => '3519070009', 'kecamatan_id' => '3519070', 'kode_pos' => '63381', 'name' => 'SUKOWIDI'],
    
        // Kecamatan SIDOREJO (id: 3519080)
        ['id' => '3519080001', 'kecamatan_id' => '3519080', 'kode_pos' => '63363', 'name' => 'CAMPURSARI'],
        ['id' => '3519080002', 'kecamatan_id' => '3519080', 'kode_pos' => '63363', 'name' => 'DURENAN'],
        ['id' => '3519080003', 'kecamatan_id' => '3519080', 'kode_pos' => '63363', 'name' => 'GETASANYAR'],
        ['id' => '3519080004', 'kecamatan_id' => '3519080', 'kode_pos' => '63363', 'name' => 'KALANG'],
        ['id' => '3519080005', 'kecamatan_id' => '3519080', 'kode_pos' => '63363', 'name' => 'SAMBIROBYONG'],
        ['id' => '3519080006', 'kecamatan_id' => '3519080', 'kode_pos' => '63363', 'name' => 'SIDOKERTO'],
        ['id' => '3519080007', 'kecamatan_id' => '3519080', 'kode_pos' => '63363', 'name' => 'SIDOMULYO'],
        ['id' => '3519080008', 'kecamatan_id' => '3519080', 'kode_pos' => '63363', 'name' => 'SIDOREJO'],
        ['id' => '3519080009', 'kecamatan_id' => '3519080', 'kode_pos' => '63363', 'name' => 'SUMBERSAWIT'],
        ['id' => '3519080010', 'kecamatan_id' => '3519080', 'kode_pos' => '63363', 'name' => 'WIDOROKANDANG'],
    
        // Kecamatan PANEKAN (id: 3519090)
        ['id' => '3519090001', 'kecamatan_id' => '3519090', 'kode_pos' => '63352', 'name' => 'BANJAREJO'],
        ['id' => '3519090002', 'kecamatan_id' => '3519090', 'kode_pos' => '63352', 'name' => 'BEDAGUNG'],
        ['id' => '3519090003', 'kecamatan_id' => '3519090', 'kode_pos' => '63352', 'name' => 'CEPOKO'],
        ['id' => '3519090004', 'kecamatan_id' => '3519090', 'kode_pos' => '63352', 'name' => 'JABUNG'],
        ['id' => '3519090005', 'kecamatan_id' => '3519090', 'kode_pos' => '63352', 'name' => 'MANJUNG'],
        ['id' => '3519090006', 'kecamatan_id' => '3519090', 'kode_pos' => '63352', 'name' => 'MILANGASRI'],
        ['id' => '3519090007', 'kecamatan_id' => '3519090', 'kode_pos' => '63352', 'name' => 'NGILIRAN'],
        ['id' => '3519090008', 'kecamatan_id' => '3519090', 'kode_pos' => '63352', 'name' => 'REJOMULYO'],
        ['id' => '3519090009', 'kecamatan_id' => '3519090', 'kode_pos' => '63352', 'name' => 'SIDOWAYAH'],
        ['id' => '3519090010', 'kecamatan_id' => '3519090', 'kode_pos' => '63352', 'name' => 'SUKOWIDI'],
        ['id' => '3519090011', 'kecamatan_id' => '3519090', 'kode_pos' => '63352', 'name' => 'SUMBERDODOL'],
        ['id' => '3519090012', 'kecamatan_id' => '3519090', 'kode_pos' => '63352', 'name' => 'TANJUNGSARI'],
        ['id' => '3519090013', 'kecamatan_id' => '3519090', 'kode_pos' => '63352', 'name' => 'TAPAK'],
        ['id' => '3519090014', 'kecamatan_id' => '3519090', 'kode_pos' => '63352', 'name' => 'TERUNG'],
        ['id' => '3519090015', 'kecamatan_id' => '3519090', 'kode_pos' => '63352', 'name' => 'TURI'],
    
        // Kecamatan SUKOMORO (id: 3519100)
        ['id' => '3519100001', 'kecamatan_id' => '3519100', 'kode_pos' => '63391', 'name' => 'BANDAR'],
        ['id' => '3519100002', 'kecamatan_id' => '3519100', 'kode_pos' => '63391', 'name' => 'BIBIS'],
        ['id' => '3519100003', 'kecamatan_id' => '3519100', 'kode_pos' => '63391', 'name' => 'BOGEM'],
        ['id' => '3519100004', 'kecamatan_id' => '3519100', 'kode_pos' => '63391', 'name' => 'BULU'],
        ['id' => '3519100005', 'kecamatan_id' => '3519100', 'kode_pos' => '63391', 'name' => 'KALANGKETI'],
        ['id' => '3519100006', 'kecamatan_id' => '3519100', 'kode_pos' => '63391', 'name' => 'KEDUNGGUWO'],
        ['id' => '3519100007', 'kecamatan_id' => '3519100', 'kode_pos' => '63391', 'name' => 'KEMBANGAN'],
        ['id' => '3519100008', 'kecamatan_id' => '3519100', 'kode_pos' => '63391', 'name' => 'KENTANGAN'],
        ['id' => '3519100009', 'kecamatan_id' => '3519100', 'kode_pos' => '63391', 'name' => 'POJOKSARI'],
        ['id' => '3519100010', 'kecamatan_id' => '3519100', 'kode_pos' => '63391', 'name' => 'SUKOMORO'],
        ['id' => '3519100011', 'kecamatan_id' => '3519100', 'kode_pos' => '63391', 'name' => 'TAMANAN'],
        ['id' => '3519100012', 'kecamatan_id' => '3519100', 'kode_pos' => '63391', 'name' => 'TAMBAKMAS'],
        ['id' => '3519100013', 'kecamatan_id' => '3519100', 'kode_pos' => '63391', 'name' => 'TRUNENG'],
        ['id' => '3519100014', 'kecamatan_id' => '3519100', 'kode_pos' => '63391', 'name' => 'TINAP'],
    
        // Kecamatan BENDO (id: 3519110)
        ['id' => '3519110001', 'kecamatan_id' => '3519110', 'kode_pos' => '63384', 'name' => 'BELOTAN'],
        ['id' => '3519110002', 'kecamatan_id' => '3519110', 'kode_pos' => '63384', 'name' => 'BULAK'],
        ['id' => '3519110003', 'kecamatan_id' => '3519110', 'kode_pos' => '63384', 'name' => 'BULUGLEDEG'],
        ['id' => '3519110004', 'kecamatan_id' => '3519110', 'kode_pos' => '63384', 'name' => 'CARIKAN'],
        ['id' => '3519110005', 'kecamatan_id' => '3519110', 'kode_pos' => '63384', 'name' => 'DUKUH'],
        ['id' => '3519110006', 'kecamatan_id' => '3519110', 'kode_pos' => '63384', 'name' => 'DUWET'],
        ['id' => '3519110007', 'kecamatan_id' => '3519110', 'kode_pos' => '63384', 'name' => 'KLECO'],
        ['id' => '3519110008', 'kecamatan_id' => '3519110', 'kode_pos' => '63384', 'name' => 'KLEDOKAN'],
        ['id' => '3519110009', 'kecamatan_id' => '3519110', 'kode_pos' => '63384', 'name' => 'KINANDANG'],
        ['id' => '3519110010', 'kecamatan_id' => '3519110', 'kode_pos' => '63384', 'name' => 'LEMAHBANG'],
        ['id' => '3519110011', 'kecamatan_id' => '3519110', 'kode_pos' => '63384', 'name' => 'PINGKUK'],
        ['id' => '3519110012', 'kecamatan_id' => '3519110', 'kode_pos' => '63384', 'name' => 'SETREN'],
        ['id' => '3519110013', 'kecamatan_id' => '3519110', 'kode_pos' => '63384', 'name' => 'SOCO'],
        ['id' => '3519110014', 'kecamatan_id' => '3519110', 'kode_pos' => '63384', 'name' => 'TANJUNG'],
        ['id' => '3519110015', 'kecamatan_id' => '3519110', 'kode_pos' => '63384', 'name' => 'TEGALARUM'],
        ['id' => '3519110016', 'kecamatan_id' => '3519110', 'kode_pos' => '63384', 'name' => 'BENDO'],
    
        // === MAOSPATI ===
        ['id' => '3519120001', 'kecamatan_id' => '3519120', 'kode_pos' => '63392', 'name' => 'GULUN'],
        ['id' => '3519120002', 'kecamatan_id' => '3519120', 'kode_pos' => '63392', 'name' => 'KLAGEN'],
        ['id' => '3519120003', 'kecamatan_id' => '3519120', 'kode_pos' => '63392', 'name' => 'GAMBIRAN'],
        ['id' => '3519120004', 'kecamatan_id' => '3519120', 'kode_pos' => '63392', 'name' => 'MALANG'],
        ['id' => '3519120005', 'kecamatan_id' => '3519120', 'kode_pos' => '63392', 'name' => 'NGUJUNG'],
        ['id' => '3519120006', 'kecamatan_id' => '3519120', 'kode_pos' => '63392', 'name' => 'PANDEYAN'],
        ['id' => '3519120007', 'kecamatan_id' => '3519120', 'kode_pos' => '63392', 'name' => 'PESU'],
        ['id' => '3519120008', 'kecamatan_id' => '3519120', 'kode_pos' => '63392', 'name' => 'RONOWIJAYAN'],
        ['id' => '3519120009', 'kecamatan_id' => '3519120', 'kode_pos' => '63392', 'name' => 'SEMPOL'],
        ['id' => '3519120010', 'kecamatan_id' => '3519120', 'kode_pos' => '63392', 'name' => 'SUGIHWARAS'],
        ['id' => '3519120011', 'kecamatan_id' => '3519120', 'kode_pos' => '63392', 'name' => 'SUMBEREJO'],
        ['id' => '3519120012', 'kecamatan_id' => '3519120', 'kode_pos' => '63392', 'name' => 'SURATMAJAN'],
        ['id' => '3519120013', 'kecamatan_id' => '3519120', 'kode_pos' => '63392', 'name' => 'TANJUNGSEPREH'],
        ['id' => '3519120014', 'kecamatan_id' => '3519120', 'kode_pos' => '63392', 'name' => 'KRATON'],
        ['id' => '3519120015', 'kecamatan_id' => '3519120', 'kode_pos' => '63392', 'name' => 'MAOSPATI'],
        ['id' => '3519120016', 'kecamatan_id' => '3519120', 'kode_pos' => '63392', 'name' => 'MRANGGEN'],
    
        // === KARANGREJO ===
        ['id' => '3519130001', 'kecamatan_id' => '3519130', 'kode_pos' => '63395', 'name' => 'BALUK'],
        ['id' => '3519130002', 'kecamatan_id' => '3519130', 'kode_pos' => '63395', 'name' => 'GEBYOK'],
        ['id' => '3519130003', 'kecamatan_id' => '3519130', 'kode_pos' => '63395', 'name' => 'GONDANG'],
        ['id' => '3519130004', 'kecamatan_id' => '3519130', 'kode_pos' => '63395', 'name' => 'GRABAHAN'],
        ['id' => '3519130005', 'kecamatan_id' => '3519130', 'kode_pos' => '63395', 'name' => 'KAUMAN'],
        ['id' => '3519130006', 'kecamatan_id' => '3519130', 'kode_pos' => '63395', 'name' => 'MANTREN'],
        ['id' => '3519130007', 'kecamatan_id' => '3519130', 'kode_pos' => '63395', 'name' => 'MARON'],
        ['id' => '3519130008', 'kecamatan_id' => '3519130', 'kode_pos' => '63395', 'name' => 'PATIHAN'],
        ['id' => '3519130009', 'kecamatan_id' => '3519130', 'kode_pos' => '63395', 'name' => 'PELEM'],
        ['id' => '3519130010', 'kecamatan_id' => '3519130', 'kode_pos' => '63395', 'name' => 'PRAMPELAN'],
        ['id' => '3519130011', 'kecamatan_id' => '3519130', 'kode_pos' => '63395', 'name' => 'SAMBIREMBE'],
        ['id' => '3519130012', 'kecamatan_id' => '3519130', 'kode_pos' => '63395', 'name' => 'KARANGREJO'],
        ['id' => '3519130013', 'kecamatan_id' => '3519130', 'kode_pos' => '63395', 'name' => 'MANISREJO'],
    
        // === KARAS ===
        ['id' => '3519140001', 'kecamatan_id' => '3519140', 'kode_pos' => '63396', 'name' => 'BOTOK'],
        ['id' => '3519140002', 'kecamatan_id' => '3519140', 'kode_pos' => '63396', 'name' => 'GEPLAK'],
        ['id' => '3519140003', 'kecamatan_id' => '3519140', 'kode_pos' => '63396', 'name' => 'GINUK'],
        ['id' => '3519140004', 'kecamatan_id' => '3519140', 'kode_pos' => '63396', 'name' => 'JUNGKE'],
        ['id' => '3519140005', 'kecamatan_id' => '3519140', 'kode_pos' => '63396', 'name' => 'KARAS'],
        ['id' => '3519140006', 'kecamatan_id' => '3519140', 'kode_pos' => '63396', 'name' => 'KUWON'],
        ['id' => '3519140007', 'kecamatan_id' => '3519140', 'kode_pos' => '63396', 'name' => 'SOBONTORO'],
        ['id' => '3519140008', 'kecamatan_id' => '3519140', 'kode_pos' => '63396', 'name' => 'SUMURSONGO'],
        ['id' => '3519140009', 'kecamatan_id' => '3519140', 'kode_pos' => '63396', 'name' => 'TAJI'],
        ['id' => '3519140010', 'kecamatan_id' => '3519140', 'kode_pos' => '63396', 'name' => 'TEMBORO'],
        ['id' => '3519140011', 'kecamatan_id' => '3519140', 'kode_pos' => '63396', 'name' => 'TEMENGGUNG'],
    
        // === BARAT ===
        ['id' => '3519150001', 'kecamatan_id' => '3519150', 'kode_pos' => '63393', 'name' => 'BANGUNASRI'],
        ['id' => '3519150002', 'kecamatan_id' => '3519150', 'kode_pos' => '63393', 'name' => 'BANJAREJO'],
        ['id' => '3519150003', 'kecamatan_id' => '3519150', 'kode_pos' => '63393', 'name' => 'BLARAN'],
        ['id' => '3519150004', 'kecamatan_id' => '3519150', 'kode_pos' => '63393', 'name' => 'BOGOREJO'],
        ['id' => '3519150005', 'kecamatan_id' => '3519150', 'kode_pos' => '63393', 'name' => 'BULUREJO'],
        ['id' => '3519150006', 'kecamatan_id' => '3519150', 'kode_pos' => '63393', 'name' => 'JATISARI'],
        ['id' => '3519150007', 'kecamatan_id' => '3519150', 'kode_pos' => '63393', 'name' => 'MANTREN'],
        ['id' => '3519150008', 'kecamatan_id' => '3519150', 'kode_pos' => '63393', 'name' => 'PANGGUNGREJO'],
        ['id' => '3519150009', 'kecamatan_id' => '3519150', 'kode_pos' => '63393', 'name' => 'PONDOHARJO'],
        ['id' => '3519150010', 'kecamatan_id' => '3519150', 'kode_pos' => '63393', 'name' => 'SAMBIREJO'],
    
        // === KARTOHARJO ===
        ['id' => '3519160001', 'kecamatan_id' => '3519160', 'kode_pos' => '63391', 'name' => 'KARTOHARJO'],
        ['id' => '3519160002', 'kecamatan_id' => '3519160', 'kode_pos' => '63391', 'name' => 'SUKOREJO'],
        ['id' => '3519160003', 'kecamatan_id' => '3519160', 'kode_pos' => '63391', 'name' => 'KLUMPRING'],
        ['id' => '3519160004', 'kecamatan_id' => '3519160', 'kode_pos' => '63391', 'name' => 'TANJUNGREJO'],
    
        // === NGARIBOYO ===
        ['id' => '3519170001', 'kecamatan_id' => '3519170', 'kode_pos' => '63397', 'name' => 'NGARIBOYO'],
        ['id' => '3519170002', 'kecamatan_id' => '3519170', 'kode_pos' => '63397', 'name' => 'KARANGREJO'],
        ['id' => '3519170003', 'kecamatan_id' => '3519170', 'kode_pos' => '63397', 'name' => 'SUKOREJO'],
        ['id' => '3519170004', 'kecamatan_id' => '3519170', 'kode_pos' => '63397', 'name' => 'NGUNUT'],
    ];

    public function getAllKabupaten()
    {
        return $this->kabupatenKota;
    }

    public function getKecamatanByKabupaten($kabupatenId)
    {
        return collect($this->kecamatans)
            ->where('kabupaten_id', $kabupatenId)
            ->values()
            ->all();
    }

    public function getKelurahanByKecamatan($kecamatanId)
    {
        $filtered = array_filter($this->kelurahans, function($item) use ($kecamatanId) {
            return $item['kecamatan_id'] == $kecamatanId;
        });

        $result = [];
        foreach ($filtered as $kelurahan) {
            $result[] = [
                'id' => $kelurahan['id'],
                'name' => $kelurahan['name'],
                'kode_pos' => $kelurahan['kode_pos']
            ];
        }
        return $result;
    }

    public function getKecamatanName($id)
    {
        $kecamatan = collect($this->kecamatans)->firstWhere('id', $id);
        return $kecamatan ? $kecamatan['name'] : $id;
    }

    public function getKelurahanName($id)
    {
        $kelurahan = collect($this->kelurahans)->firstWhere('id', $id);
        return $kelurahan ? $kelurahan['name'] : $id;
    }
}
