<?php

/**
 * Amaron after-market retail price list — Amara Raja Energy & Mobility Limited.
 *
 * Source : "Amaron Auto DP wef 15.08.26.pdf"
 *          Ref. AREML/AMARON/FY27/4W/RET/02, dated 15 Aug 2026
 * Prices : Retailer Price (Rs.) w.e.f. 15.08.2026, inclusive of GST.
 *
 * Only the two facts the price list actually carries are recorded here — the
 * manufacturer SKU and its retail price. The PDF states no Ah rating, warranty
 * term or dimensions, so those are left unset rather than guessed; fill them in
 * per product via /admin/products.
 *
 * @return array<int, array{sku: string, series: string, name: string, price: int}>
 */
return [

    // ── Amaron PRO ───────────────────────────────────────────────── 6 SKUs
    ['sku' => 'AAM-PR-00050B20L', 'series' => 'PRO', 'name' => 'Amaron PRO 50B20L', 'price' => 4701],
    ['sku' => 'AAM-PR-00050B20R', 'series' => 'PRO', 'name' => 'Amaron PRO 50B20R', 'price' => 4701],
    ['sku' => 'AAM-PR-0055B24LS', 'series' => 'PRO', 'name' => 'Amaron PRO 55B24LS', 'price' => 7058],
    ['sku' => 'AAM-PR-574102069', 'series' => 'PRO', 'name' => 'Amaron PRO 574102069', 'price' => 10376],
    ['sku' => 'AAM-PR-600109087', 'series' => 'PRO', 'name' => 'Amaron PRO 600109087', 'price' => 17027],
    ['sku' => 'AAM-PR-0BH80D31L', 'series' => 'PRO', 'name' => 'Amaron PRO BH80D31L', 'price' => 15202],

    // ── Amaron FLO ───────────────────────────────────────────────── 21 SKUs
    ['sku' => 'AAM-FL-00040B20L', 'series' => 'FLO', 'name' => 'Amaron FLO 40B20L', 'price' => 4027],
    ['sku' => 'AAM-FL-00040B20R', 'series' => 'FLO', 'name' => 'Amaron FLO 40B20R', 'price' => 4027],
    ['sku' => 'AAM-FL-00042B20L', 'series' => 'FLO', 'name' => 'Amaron FLO 42B20L', 'price' => 4287],
    ['sku' => 'AAM-FL-00042B20R', 'series' => 'FLO', 'name' => 'Amaron FLO 42B20R', 'price' => 4287],
    ['sku' => 'AAM-FL-0BH40B20L', 'series' => 'FLO', 'name' => 'Amaron FLO BH40B20L', 'price' => 4487],
    ['sku' => 'AAM-FL-0BH45D20L', 'series' => 'FLO', 'name' => 'Amaron FLO BH45D20L', 'price' => 6010],
    ['sku' => 'AAM-FL-0BH90D23L', 'series' => 'FLO', 'name' => 'Amaron FLO BH90D23L', 'price' => 6490],
    ['sku' => 'AAM-FL-545106036', 'series' => 'FLO', 'name' => 'Amaron FLO 545106036', 'price' => 5486],
    ['sku' => 'AAM-FL-555112054', 'series' => 'FLO', 'name' => 'Amaron FLO 555112054', 'price' => 6947],
    ['sku' => 'AAM-FL-566112060', 'series' => 'FLO', 'name' => 'Amaron FLO 566112060', 'price' => 7100],
    ['sku' => 'AAM-FL-00080D23L', 'series' => 'FLO', 'name' => 'Amaron FLO 80D23L', 'price' => 6170],
    ['sku' => 'AAM-FL-550113042', 'series' => 'FLO', 'name' => 'Amaron FLO 550113042', 'price' => 6072],
    ['sku' => 'AAM-FL-550114042', 'series' => 'FLO', 'name' => 'Amaron FLO 550114042', 'price' => 6072],
    ['sku' => 'AAM-FL-555111054', 'series' => 'FLO', 'name' => 'Amaron FLO 555111054', 'price' => 6947],
    ['sku' => 'AAM-FL-565106590', 'series' => 'FLO', 'name' => 'Amaron FLO 565106590', 'price' => 7113],
    ['sku' => 'AAM-FL-580112073', 'series' => 'FLO', 'name' => 'Amaron FLO 580112073', 'price' => 10358],
    ['sku' => 'AMS-FL-00040B20L', 'series' => 'FLO', 'name' => 'Amaron FLO 40B20L (AMS)', 'price' => 4027],
    ['sku' => 'AMS-FL-00042B20L', 'series' => 'FLO', 'name' => 'Amaron FLO 42B20L (AMS)', 'price' => 4287],
    ['sku' => 'AMS-FL-00042B20R', 'series' => 'FLO', 'name' => 'Amaron FLO 42B20R (AMS)', 'price' => 4287],
    ['sku' => 'AMS-FL-550114042', 'series' => 'FLO', 'name' => 'Amaron FLO 550114042 (AMS)', 'price' => 6072],
    ['sku' => 'AMS-FL-565106590', 'series' => 'FLO', 'name' => 'Amaron FLO 565106590 (AMS)', 'price' => 7113],

    // ── Amaron GO ────────────────────────────────────────────────── 16 SKUs
    ['sku' => 'AAM-GO-00034B20L', 'series' => 'GO', 'name' => 'Amaron GO 34B20L', 'price' => 3762],
    ['sku' => 'AAM-GO-00034B20R', 'series' => 'GO', 'name' => 'Amaron GO 34B20R', 'price' => 3762],
    ['sku' => 'AAM-GO-00038B20L', 'series' => 'GO', 'name' => 'Amaron GO 38B20L', 'price' => 3473],
    ['sku' => 'AAM-GO-00038B20R', 'series' => 'GO', 'name' => 'Amaron GO 38B20R', 'price' => 3473],
    ['sku' => 'AAM-GO-0BH38B20R', 'series' => 'GO', 'name' => 'Amaron GO BH38B20R', 'price' => 4393],
    ['sku' => 'AAM-GO-00050B24L', 'series' => 'GO', 'name' => 'Amaron GO 50B24L', 'price' => 5866],
    ['sku' => 'AAM-GO-00095D26L', 'series' => 'GO', 'name' => 'Amaron GO 95D26L', 'price' => 6794],
    ['sku' => 'AAM-GO-00095D26R', 'series' => 'GO', 'name' => 'Amaron GO 95D26R', 'price' => 6794],
    ['sku' => 'AAM-GO-565106590', 'series' => 'GO', 'name' => 'Amaron GO 565106590', 'price' => 6857],
    ['sku' => 'AAM-GO-00085D23R', 'series' => 'GO', 'name' => 'Amaron GO 85D23R', 'price' => 6438],
    ['sku' => 'AAM-GO-00105D26R', 'series' => 'GO', 'name' => 'Amaron GO 105D26R', 'price' => 7466],
    ['sku' => 'AAM-GO-00105D26L', 'series' => 'GO', 'name' => 'Amaron GO 105D26L', 'price' => 7466],
    ['sku' => 'AAM-GO-00105D31R', 'series' => 'GO', 'name' => 'Amaron GO 105D31R', 'price' => 7318],
    ['sku' => 'AAM-GO-00105D31L', 'series' => 'GO', 'name' => 'Amaron GO 105D31L', 'price' => 7318],
    ['sku' => 'AAM-GO-00135D31R', 'series' => 'GO', 'name' => 'Amaron GO 135D31R', 'price' => 8008],
    ['sku' => 'AAM-GO-00135D31L', 'series' => 'GO', 'name' => 'Amaron GO 135D31L', 'price' => 8008],

    // ── Amaron DURO ──────────────────────────────────────────────── 6 SKUs
    ['sku' => 'AAM-DR-EFB60B20L', 'series' => 'DURO', 'name' => 'Amaron DURO EFB60B20L', 'price' => 4449],
    ['sku' => 'AAM-DR-EFB80B24L', 'series' => 'DURO', 'name' => 'Amaron DURO EFB80B24L', 'price' => 5857],
    ['sku' => 'AAM-DR-EFBDIN70L', 'series' => 'DURO', 'name' => 'Amaron DURO EFBDIN70L', 'price' => 7761],
    ['sku' => 'AAM-DR-EF100D23R', 'series' => 'DURO', 'name' => 'Amaron DURO EF100D23R', 'price' => 6547],
    ['sku' => 'AAM-DR-EFBDIN47R', 'series' => 'DURO', 'name' => 'Amaron DURO EFBDIN47R', 'price' => 5865],
    ['sku' => 'AAM-DR-EFBDIN52R', 'series' => 'DURO', 'name' => 'Amaron DURO EFBDIN52R', 'price' => 5926],

    // ── Amaron JADE ──────────────────────────────────────────────── 2 SKUs
    ['sku' => 'AAM-JD-AGMDIN50L', 'series' => 'JADE', 'name' => 'Amaron JADE AGMDIN50L', 'price' => 6308],
    ['sku' => 'AAM-JD-AGMDIN60L', 'series' => 'JADE', 'name' => 'Amaron JADE AGMDIN60L', 'price' => 8566],

    // ── Amaron BLACK ─────────────────────────────────────────────── 40 SKUs
    ['sku' => 'AAM-BL-BL0300RMF', 'series' => 'BLACK', 'name' => 'Amaron BLACK BL0300RMF', 'price' => 3066],
    ['sku' => 'AAM-BL-0BL400LMF', 'series' => 'BLACK', 'name' => 'Amaron BLACK BL400LMF', 'price' => 3340],
    ['sku' => 'AAM-BL-0BL400RMF', 'series' => 'BLACK', 'name' => 'Amaron BLACK BL400RMF', 'price' => 3340],
    ['sku' => 'AAM-BL-BL00500RS', 'series' => 'BLACK', 'name' => 'Amaron BLACK BL00500RS', 'price' => 5701],
    ['sku' => 'AAM-BL-BL00500LS', 'series' => 'BLACK', 'name' => 'Amaron BLACK BL00500LS', 'price' => 5701],
    ['sku' => 'AAM-BL-0BL700LMF', 'series' => 'BLACK', 'name' => 'Amaron BLACK BL700LMF', 'price' => 6255],
    ['sku' => 'AAM-BL-0BL700RMF', 'series' => 'BLACK', 'name' => 'Amaron BLACK BL700RMF', 'price' => 6255],
    ['sku' => 'AAM-BL-0BL800LMF', 'series' => 'BLACK', 'name' => 'Amaron BLACK BL800LMF', 'price' => 6366],
    ['sku' => 'AAM-BL-0BL800RMF', 'series' => 'BLACK', 'name' => 'Amaron BLACK BL800RMF', 'price' => 6366],
    ['sku' => 'AAM-BL-BL880D31R', 'series' => 'BLACK', 'name' => 'Amaron BLACK BL880D31R', 'price' => 6591],
    ['sku' => 'AAM-BL-BL880D31L', 'series' => 'BLACK', 'name' => 'Amaron BLACK BL880D31L', 'price' => 6591],
    ['sku' => 'AAM-BL-0BL900LMF', 'series' => 'BLACK', 'name' => 'Amaron BLACK BL900LMF', 'price' => 6904],
    ['sku' => 'AAM-BL-0BL900RMF', 'series' => 'BLACK', 'name' => 'Amaron BLACK BL900RMF', 'price' => 6904],
    ['sku' => 'AAM-BL-BL1000LMF', 'series' => 'BLACK', 'name' => 'Amaron BLACK BL1000LMF', 'price' => 7464],
    ['sku' => 'AAM-BL-BL1000RMF', 'series' => 'BLACK', 'name' => 'Amaron BLACK BL1000RMF', 'price' => 7464],
    ['sku' => 'AAM-BL-BL1300RMF', 'series' => 'BLACK', 'name' => 'Amaron BLACK BL1300RMF', 'price' => 10243],
    ['sku' => 'AAM-BL-BL1500RMF', 'series' => 'BLACK', 'name' => 'Amaron BLACK BL1500RMF', 'price' => 12171],
    ['sku' => 'AAM-BL-0BL600LMF', 'series' => 'BLACK', 'name' => 'Amaron BLACK BL600LMF', 'price' => 5153],
    ['sku' => 'AAM-BL-0BL600RMF', 'series' => 'BLACK', 'name' => 'Amaron BLACK BL600RMF', 'price' => 5153],
    ['sku' => 'AAM-BL-BL0030RMF', 'series' => 'BLACK', 'name' => 'Amaron BLACK BL0030RMF', 'price' => 2890],
    ['sku' => 'AAM-BL-BL0040LMF', 'series' => 'BLACK', 'name' => 'Amaron BLACK BL0040LMF', 'price' => 3204],
    ['sku' => 'AAM-BL-BL0040RMF', 'series' => 'BLACK', 'name' => 'Amaron BLACK BL0040RMF', 'price' => 3204],
    ['sku' => 'AAM-BL-0BL0050LS', 'series' => 'BLACK', 'name' => 'Amaron BLACK BL0050LS', 'price' => 5504],
    ['sku' => 'AAM-BL-0BL0050RS', 'series' => 'BLACK', 'name' => 'Amaron BLACK BL0050RS', 'price' => 5504],
    ['sku' => 'AAM-BL-BL0060LMF', 'series' => 'BLACK', 'name' => 'Amaron BLACK BL0060LMF', 'price' => 4907],
    ['sku' => 'AAM-BL-BL0060RMF', 'series' => 'BLACK', 'name' => 'Amaron BLACK BL0060RMF', 'price' => 4907],
    ['sku' => 'AAM-BL-BL0070LMF', 'series' => 'BLACK', 'name' => 'Amaron BLACK BL0070LMF', 'price' => 5995],
    ['sku' => 'AAM-BL-BL0070RMF', 'series' => 'BLACK', 'name' => 'Amaron BLACK BL0070RMF', 'price' => 5995],
    ['sku' => 'AAM-BL-BL0080LMF', 'series' => 'BLACK', 'name' => 'Amaron BLACK BL0080LMF', 'price' => 6104],
    ['sku' => 'AAM-BL-BL0080RMF', 'series' => 'BLACK', 'name' => 'Amaron BLACK BL0080RMF', 'price' => 6104],
    ['sku' => 'AAM-BL-BL0090LMF', 'series' => 'BLACK', 'name' => 'Amaron BLACK BL0090LMF', 'price' => 6551],
    ['sku' => 'AAM-BL-BL0090RMF', 'series' => 'BLACK', 'name' => 'Amaron BLACK BL0090RMF', 'price' => 6551],
    ['sku' => 'AAM-BL-BL090E41L', 'series' => 'BLACK', 'name' => 'Amaron BLACK BL090E41L', 'price' => 6713],
    ['sku' => 'AAM-BL-BL090E41R', 'series' => 'BLACK', 'name' => 'Amaron BLACK BL090E41R', 'price' => 6713],
    ['sku' => 'AAM-BL-BL100E41L', 'series' => 'BLACK', 'name' => 'Amaron BLACK BL100E41L', 'price' => 7319],
    ['sku' => 'AAM-BL-BL100E41R', 'series' => 'BLACK', 'name' => 'Amaron BLACK BL100E41R', 'price' => 7319],
    ['sku' => 'AAM-BL-0BL100LMF', 'series' => 'BLACK', 'name' => 'Amaron BLACK BL100LMF', 'price' => 7225],
    ['sku' => 'AAM-BL-0BL100RMF', 'series' => 'BLACK', 'name' => 'Amaron BLACK BL100RMF', 'price' => 7225],
    ['sku' => 'AAM-BL-0BL130RMF', 'series' => 'BLACK', 'name' => 'Amaron BLACK BL130RMF', 'price' => 9893],
    ['sku' => 'AAM-BL-0BL150RMF', 'series' => 'BLACK', 'name' => 'Amaron BLACK BL150RMF', 'price' => 11792],

    // ── Amaron HI-WAY ────────────────────────────────────────────── 9 SKUs
    ['sku' => 'AAM-HW-HC620D31R', 'series' => 'HI-WAY', 'name' => 'Amaron HI-WAY HC620D31R', 'price' => 6906],
    ['sku' => 'AAM-HW-NT650H29R', 'series' => 'HI-WAY', 'name' => 'Amaron HI-WAY NT650H29R', 'price' => 7408],
    ['sku' => 'AAM-HW-NT800D04R', 'series' => 'HI-WAY', 'name' => 'Amaron HI-WAY NT800D04R', 'price' => 12207],
    ['sku' => 'AAM-HW-NTX00D04R', 'series' => 'HI-WAY', 'name' => 'Amaron HI-WAY NTX00D04R', 'price' => 14034],
    ['sku' => 'AAM-HW-HC180D04R', 'series' => 'HI-WAY', 'name' => 'Amaron HI-WAY HC180D04R', 'price' => 15828],
    ['sku' => 'AAM-HW-HCX20H52R', 'series' => 'HI-WAY', 'name' => 'Amaron HI-WAY HCX20H52R', 'price' => 16500],
    ['sku' => 'AAM-HW-NT800E41R', 'series' => 'HI-WAY', 'name' => 'Amaron HI-WAY NT800E41R', 'price' => 9794],
    ['sku' => 'AAM-HW-NT700E41R', 'series' => 'HI-WAY', 'name' => 'Amaron HI-WAY NT700E41R', 'price' => 8649],
    ['sku' => 'AAM-HW-NT800F51R', 'series' => 'HI-WAY', 'name' => 'Amaron HI-WAY NT800F51R', 'price' => 10811],

    // ── Amaron HARVEST ───────────────────────────────────────────── 6 SKUs
    ['sku' => 'AAM-HR-TR500D31L', 'series' => 'HARVEST', 'name' => 'Amaron HARVEST TR500D31L', 'price' => 6803],
    ['sku' => 'AAM-HR-TR500D31R', 'series' => 'HARVEST', 'name' => 'Amaron HARVEST TR500D31R', 'price' => 6803],
    ['sku' => 'AAM-HR-NT600H29L', 'series' => 'HARVEST', 'name' => 'Amaron HARVEST NT600H29L', 'price' => 7334],
    ['sku' => 'AAM-HR-NT600H29R', 'series' => 'HARVEST', 'name' => 'Amaron HARVEST NT600H29R', 'price' => 7334],
    ['sku' => 'AAM-HR-NT600E41R', 'series' => 'HARVEST', 'name' => 'Amaron HARVEST NT600E41R', 'price' => 7614],
    ['sku' => 'AAM-HR-NT600E41L', 'series' => 'HARVEST', 'name' => 'Amaron HARVEST NT600E41L', 'price' => 7614],
];
