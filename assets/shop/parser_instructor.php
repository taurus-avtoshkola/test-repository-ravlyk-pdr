<?php
// Подключаем
define('MODX_API_MODE', true);
define ('ROOT', dirname(dirname(dirname(__FILE__))));
define ('MODX_BASE_PATH', ROOT.'/');
define ('MODX_BASE_URL', '/');
define ('MODX_SITE_URL', 'https://pdr-online.com.ua/');
require ROOT.'/index.php';
include MODX_BASE_PATH . "assets/shop/shop.class.php";
$shop = new Shop($modx);

include MODX_BASE_PATH."assets/shop/phpQuery/phpQuery.php";



die;



/*
$data = 'https://www.olx.ua/d/uk/obyavlenie/nstruktor-z-vodnnya-privatn-uroki-vodnnya-avtoinstruktor-IDS1ODu.html:798355120:0634431914
https://www.olx.ua/d/uk/obyavlenie/avtoinstruktor-obuchenie-vozhdeniyu-instruktor-po-vozhdeniyu-IDS1IUt.html:798333109:0634428714
https://www.olx.ua/d/uk/obyavlenie/zhnochiy-nstruktor-privatn-uroki-avtoinstruktor-IDS1xO0.html:798290424:0636971795
https://www.olx.ua/d/uk/obyavlenie/nstruktor-z-vodnnya-avtonstruktor-uroki-vodnnya-avtoinstruktor-IDS1WaP.html:798380251:0633825655
https://www.olx.ua/d/uk/obyavlenie/avtoinstruktor-mkpp-IDUgQps.html:831489530:0633425784
https://www.olx.ua/d/uk/obyavlenie/avtoinstruktor-mkpp-akpp-IDMYg7V.html:723625804:0933589230
https://www.olx.ua/d/uk/obyavlenie/instruktor-po-vozhdeniyu-avtoinstruktor-uroki-vozhdeniya-avtoshkola-IDS2InX.html:798569421:0632211052
https://www.olx.ua/d/uk/obyavlenie/avtoinstruktor-nstruktor-z-vodnnya-na-ka-ceed-IDS2RhC.html:798603624:0638062950
https://www.olx.ua/d/uk/obyavlenie/avtoinstruktor-350-vozhdenie-bez-straha-IDTqT7G.html:819106904:0950590455
https://www.olx.ua/d/uk/obyavlenie/instruktor-po-vozhdeniyu-avtoinstruktor-uroki-vozhdeniya-IDU9rf1.html:829724487:0682010092
https://www.olx.ua/d/uk/obyavlenie/avtoinstruktor-harkov-uroki-vozhdeniya-IDHBrLB.html:644307323:0959457250
https://www.olx.ua/d/uk/obyavlenie/instruktor-po-vozhdeniyu-uroki-vozhdeniya-avtoinstruktor-400grn-IDDleYP.html:581339579:0931462432
https://www.olx.ua/d/uk/obyavlenie/avtoinstruktor-harkov-obuchenie-vozhdeniyu-vozhdenie-avtomat-i-mehanika-IDtIoS6.html:439095786:+380678005570
https://www.olx.ua/d/uk/obyavlenie/avtonstruktor-m-rvne-uroki-vodnnya-IDTcZkG.html:815794182:0992449947
https://www.olx.ua/d/uk/obyavlenie/nstruktor-z-vodnnya-avtonstruktor-privatn-uroki-uroki-vodnnya-IDOkSYr.html:743794683:0681369123
https://www.olx.ua/d/uk/obyavlenie/avtoinstruktor-instruktor-po-vozhdeniyu-chastnye-uroki-vozhdeniya-kursy-IDJ6wab.html:666484883:+380635335373
https://www.olx.ua/d/uk/obyavlenie/avtonstruktor-mkpp-IDUlfKE.html:832540256:+380509433554
https://www.olx.ua/d/uk/obyavlenie/avtoinstruktor-nauchu-vodit-bez-straha-350gr-IDRCt1U.html:792313866:0950590455
https://www.olx.ua/d/uk/obyavlenie/avtonstruktor-privatn-uroki-vodnnya-nstruktor-z-vodnnya-IDO7nvx.html:740575525:0674950000
https://www.olx.ua/d/uk/obyavlenie/avtonstruktor-privatn-uroki-IDUtB7d.html:834529003:0633856172
https://www.olx.ua/d/uk/obyavlenie/avtonstruktor-chernvts-IDUrXRN.html:834139803:+380635964706
https://www.olx.ua/d/uk/obyavlenie/uroki-vozhdeniya-akpp-mkpp-instruktor-po-vozhdeniyu-avtoinstruktor-vinnitsa-IDNO2fu.html:735965512:+380679885431
https://www.olx.ua/d/uk/obyavlenie/avtoinstruktor-instruktor-po-vozhdeniyu-chastnye-uroki-vozhdeniya-akpp-IDUliwu.html:832550848:+380632489078
https://www.olx.ua/d/uk/obyavlenie/avtoinstruktor-mehanika-avtomat-IDUpZPh.html:833670679:0971409097
https://www.olx.ua/d/uk/obyavlenie/avtonstruktor-navchannya-vodnnyu-nstruktor-z-vodnnya-IDSVXfC.html:811972932:+380971113428
https://www.olx.ua/d/uk/obyavlenie/uchim-ezdit-na-avtomobile-avtoinstruktor-uroki-vozhdeniya-IDKIE6A.html:690352056:+380660875540
https://www.olx.ua/d/uk/obyavlenie/avtoinstruktor-uroki-vozhdeniya-IDUjgDh.html:832066987:0951338798
https://www.olx.ua/d/uk/obyavlenie/avtoinstruktor-so-stazhem-obuchenie-20-let-stazhem-vozhdenie-30-let-IDUAi1X.html:836123937:0509699988
https://www.olx.ua/d/uk/obyavlenie/avtoinstruktor-550grn-1-5-chasa-avtomat-uroki-vozhdeniya-akpp-IDTUUZC.html:826263932:0507408687
https://www.olx.ua/d/uk/obyavlenie/avtonstruktor-privatn-uroki-vodnnya-mehanka-atomat-IDTanZ1.html:815173955:0679063237
https://www.olx.ua/d/uk/obyavlenie/instruktor-po-vozhdeniyu-obuchaem-vozhdeniyu-avtoinstruktor-IDUzSq6.html:836025490:0731070012
https://www.olx.ua/d/uk/obyavlenie/avtonstruktor-yulya-lvv-IDRX7Zn.html:797237873:0966406106
https://www.olx.ua/d/uk/obyavlenie/avtonstruktor-navchannya-vodnnyu-privatn-uroki-IDODRaE.html:748315984:0979053227
https://www.olx.ua/d/uk/obyavlenie/avtoinstruktor-mkpp-pdgotovka-do-spitu-nstruktor-z-vodnnya-IDQV1Ur.html:782199839:+380683579833
https://www.olx.ua/d/uk/obyavlenie/chastnye-uroki-vozhdeniya-avtoinstruktor-instruktor-po-vozhdeniyu-IDU7G2N.html:829304733:0671313120
https://www.olx.ua/d/uk/obyavlenie/avtoinstruktor-IDTEtLH.html:822346033:0686419691
https://www.olx.ua/d/uk/obyavlenie/avtonstruktor-IDU0ULK.html:827693040:0667353304
https://www.olx.ua/d/uk/obyavlenie/avtoinstruktor-instruktor-po-vozhdeniyu-IDUyK3i.html:835754996:0502005368
https://www.olx.ua/d/uk/obyavlenie/instruktor-po-vozhdeniyu-avtoinstruktor-kursy-vozhdeniya-chastnye-uroki-IDRf71j.html:786747717:0992057070
https://www.olx.ua/d/uk/obyavlenie/uroki-z-vodnnya-avtonstruktor-navchannya-vodnnyu-z-nstruktorom-IDUr972.html:833944704:+380960967000
https://www.olx.ua/d/uk/obyavlenie/avtonstruktor-IDOosgT.html:744645351:0985497813
https://www.olx.ua/d/uk/obyavlenie/avtonstruktor-privatn-uroki-vodnnya-nstruktor-z-vodnnya-IDSVlhh.html:811826963:+380934688186
https://www.olx.ua/d/uk/obyavlenie/nstruktor-z-vodnnya-avto-avtonstruktor-IDUgKxt.html:831466963:0671305354
https://www.olx.ua/d/uk/obyavlenie/avtoinstruktor-instruktor-po-vozhdeniyu-IDJHRxr.html:675389029:0975460004
https://www.olx.ua/d/uk/obyavlenie/avtoinstruktor-nstruktor-z-vodnnya-avtomat-mehanka-avtoshkola-IDS2VtR.html:798623603:0632734868
https://www.olx.ua/d/uk/obyavlenie/avtonstruktor-dlya-dvchat-IDSGbgi.html:807975214:0987226395
https://www.olx.ua/d/uk/obyavlenie/avtonstruktor-borispl-ndivdualn-uroki-po-vodnnyu-IDQKuOZ.html:779451041:0734661636
https://www.olx.ua/d/uk/obyavlenie/avtoinstruktor-uroki-vozhdeniya-IDUv9VZ.html:835139565:0953193408
https://www.olx.ua/d/uk/obyavlenie/avtoinstruktor-IDUCDKc.html:836684060:0667414365
https://www.olx.ua/d/uk/obyavlenie/avtoinstruktor-nstruktor-z-vodnnya-mehanka-avtomat-IDS2KcM.html:798576416:0632211237
https://www.olx.ua/d/uk/obyavlenie/avtonstruktor-vodnnya-avto-kategorya-v-IDSVvsv.html:811869944:0664731513
https://www.olx.ua/d/uk/obyavlenie/avtoinstruktor-uroki-vozhdeniya-mehanika-i-avtomat-IDM0QHF.html:709466723:+380674201709
https://www.olx.ua/d/uk/obyavlenie/avtoinstruktor-uroki-vozhdeniya-avtoshkola-IDMZpWN.html:723901819:0634845308
https://www.olx.ua/d/uk/obyavlenie/avtoinstruktor-instruktor-po-vozhdeniyu-chastnye-uroki-vozhdeniya-IDQZVQh.html:783133673:0984843223
https://www.olx.ua/d/uk/obyavlenie/avtonstruktor-vodnnya-lutsk-IDUqwSr.html:833793883:+380504381593
https://www.olx.ua/d/uk/obyavlenie/uroki-vodnnya-avtonstruktor-IDRA65n.html:791749013:+380678545462
https://www.olx.ua/d/uk/obyavlenie/avtoinstruktor-uroki-vozhdeniya-IDUiZ84.html:831999704:0637507879
https://www.olx.ua/d/uk/obyavlenie/avtonstruktor-kiv-uroki-vodnnya-dlya-zhnok-shvidke-navchannya-IDT7ajG.html:814406436:0978072898
https://www.olx.ua/d/uk/obyavlenie/avtoinstruktor-mehanika-avtomat-IDHXFA9.html:649603645:0671561957
https://www.olx.ua/d/uk/obyavlenie/chastnyy-instruktor-avtoinstruktor-individualnye-uroki-vozhdeniya-IDPqTMW.html:760004117:+380635335373
https://www.olx.ua/d/uk/obyavlenie/uroki-vodnnya-privatniy-avtonstruktor-IDTR0eQ.html:825330784:+380983321003
https://www.olx.ua/d/uk/obyavlenie/avtoinstruktor-instruktor-instruktor-po-vozhdeniyu-avtoshkola-IDKhEX7.html:683920457:0997922802
https://www.olx.ua/d/uk/obyavlenie/ndivdualn-uroki-vodnnya-avtonstruktor-IDR50HU.html:784340170:0672540547
https://www.olx.ua/d/uk/obyavlenie/instruktor-s-vozhdeniya-nstruktor-z-vodnnya-avtoinstruktor-nstruktor-IDSTOe9.html:811223261:0507202849
https://www.olx.ua/d/uk/obyavlenie/nstruktor-z-vodnnya-avtonstruktor-privatn-uroki-navchannya-vodnnyu-IDUrtqj.html:834022779:+380999196853
https://www.olx.ua/d/uk/obyavlenie/avtoinstruktor-irpen-IDSrTA9.html:804570661:0987701092
https://www.olx.ua/d/uk/obyavlenie/privatn-uroki-nstruktor-z-vodnnya-avtonstruktor-ternopl-IDPLAsP.html:764934723:0972943408
https://www.olx.ua/d/uk/obyavlenie/avtonstruktor-nstruktor-z-vodnnya-privatn-uroki-uroki-vodnnya-IDSpXhb.html:804108205:+380962887788
https://www.olx.ua/d/uk/obyavlenie/avtonstruktor-pdgotovka-do-spitu-z-vodnnya-kategor-v-na-mehants-IDUcCdp.html:830481655:+380674408822
https://www.olx.ua/d/uk/obyavlenie/avtoinstruktor-uroki-vozhdeniya-uchu-na-vashem-avto-IDQVOnx.html:782386155:0934888728
https://www.olx.ua/d/uk/obyavlenie/avtoinstruktor-navchannya-vodnnyu-nstruktor-z-vodnnya-IDS3Kzg.html:798816138:0633825662
https://www.olx.ua/d/uk/obyavlenie/privatniy-nstruktor-z-vodnnya-avtonstruktor-IDUnMIa.html:833143610:0671705023
https://www.olx.ua/d/uk/obyavlenie/avtonstruktor-nstruktor-z-vodnnya-uroki-vodnnya-IDSIZjE.html:808644278:0933390231
https://www.olx.ua/d/uk/obyavlenie/zhnka-avtonstruktor-uroki-vodnnya-IDShFiz.html:802132475:0675865525
https://www.olx.ua/d/uk/obyavlenie/avtoinstruktor-po-vozhdeniyu-IDU6Ecj.html:829059307:0938087585
https://www.olx.ua/d/uk/obyavlenie/avtonstruktor-kiv-IDTSDiJ.html:825719269:0504943921
https://www.olx.ua/d/uk/obyavlenie/avtonstruktor-z-vodnnya-avtoshkola-kategorya-a-v-s-IDQJXfO.html:779322008:099-183-20-71
https://www.olx.ua/d/uk/obyavlenie/uroki-vozhdeniya-avtoinstruktor-instruktor-po-vozhdeniyu-IDSQiu0.html:810386252:+380996221347
https://www.olx.ua/d/uk/obyavlenie/uroki-vodnnya-avtonstruktor-vodnnya-navchannya-IDSWpAE.html:811605212:0933399298
https://www.olx.ua/d/uk/obyavlenie/chastnye-uroki-vozhdeniya-avtoinstruktor-instruktor-psiholog-IDJKETx.html:676055411:0939880366
https://www.olx.ua/d/uk/obyavlenie/uroki-vozhdeniya-mehanika-450grn-instruktor-po-vozhdeniyu-avtoinstruktor-IDOzx2Y.html:747285316:0665785871
https://www.olx.ua/d/uk/obyavlenie/avtoinstruktor-kiv-uroki-vozhdeniya-IDQbJAU.html:771166348:0937480089
https://www.olx.ua/d/uk/obyavlenie/uroki-vozhdeniya-avtonstruktor-avtoinstruktor-IDRsT5Y.html:790030782:0992011683
https://www.olx.ua/d/uk/obyavlenie/privatn-uroki-vodnnya-avtonstruktor-mehanka-abo-avtomat-IDTibcc.html:817031424:0971081265
https://www.olx.ua/d/uk/obyavlenie/avtonstruktor-nstruktor-z-vodnnya-IDREiJm.html:792750932:+380935065234
https://www.olx.ua/d/uk/obyavlenie/avtonstruktor-nadayu-privatn-uroki-z-vodnnya-IDSjVWJ.html:802676907:0681816497
https://www.olx.ua/d/uk/obyavlenie/uroki-vozhdeniya-avtoinstruktor-mehanika-avtomat-IDJrMzz.html:671556693:+380688431472
https://www.olx.ua/d/uk/obyavlenie/avtonstruktor-z-vodnnya-privatn-uroki-nstruktor-akpp-IDUradl.html:833948939:0673858508
https://www.olx.ua/d/uk/obyavlenie/uroki-vozhdeniya-avtoinstruktor-IDU89dK.html:829416888:0679293222
https://www.olx.ua/d/uk/obyavlenie/uroki-vozhdeniya-ot-vashego-podezda-chastnyy-avtoinstruktor-IDEg68J.html:594890293:+380674263709
https://www.olx.ua/d/uk/obyavlenie/nstruktor-z-vodnnya-avtonstruktor-instruktor-po-vozhdeniyu-IDUnpAg.html:833054708:0970010131
https://www.olx.ua/d/uk/obyavlenie/avtonstruktor-lvv-avtomat-uroki-na-avtomat-akpp-IDSikM3.html:802291907:+380981812002
https://www.olx.ua/d/uk/obyavlenie/uroki-vodnnya-avtonstruktor-uroki-vozhdeniya-instruktor-po-vozhdeniyu-IDD8L8j.html:578364911:0673828244
https://www.olx.ua/d/uk/obyavlenie/avtonstruktor-kategor-v-IDTaB22.html:815224114:+380631495459
https://www.olx.ua/d/uk/obyavlenie/avtonstruktor-uroki-vodnnya-IDTEphc.html:822328766:0686707772
https://www.olx.ua/d/uk/obyavlenie/uslugi-avtoinstruktora-IDPGbmS.html:763646614:0982545984
https://www.olx.ua/d/uk/obyavlenie/privatniy-avtonstruktor-uroki-vodnnya-kiv-lviy-praviy-bereg-IDT518n.html:813894483:0933532959
https://www.olx.ua/d/uk/obyavlenie/avtonstruktor-privatn-uroki-vodnnya-uroki-vozhdeniya-avtoshkola-IDPGixd.html:763674163:067 384 0399
https://www.olx.ua/d/uk/obyavlenie/avtonstruktor-privatn-uroki-vodnnya-avtonstruktor-lvv-IDThcno.html:816797634:0980313578
https://www.olx.ua/d/uk/obyavlenie/nstruktor-z-vodnnya-privatn-uroki-na-vashomu-avto-avtonstruktor-IDRl7nR.html:788179083:+380675281740
https://www.olx.ua/d/uk/obyavlenie/avtonstruktor-navchannya-vodnnyu-IDU1Ikv.html:827883552:+38 068 7780077
https://www.olx.ua/d/uk/obyavlenie/privatniy-avtonstruktor-uroki-vodnnya-kiv-praviy-lviy-bereg-IDU9ZEs.html:829856760:+380734157008
https://www.olx.ua/d/uk/obyavlenie/avtonstruktor-avtoinstruktor-privatn-uroki-vodnnya-uroki-vozhdeniya-IDNDXlS.html:733563408:0507477878
https://www.olx.ua/d/uk/obyavlenie/uroki-vodnnya-avtonstruktor-rvne-IDOCAty.html:748013480:0967060970
https://www.olx.ua/d/uk/obyavlenie/avtonstruktor-uroki-z-vodnnya-vdnovlennya-zabutih-navichok-IDKb4GP.html:682351095:0678605735
https://www.olx.ua/d/uk/obyavlenie/nstruktor-z-vodnnya-avtonstruktor-avtoshkola-IDQO1NY.html:780292814:+380965585780
https://www.olx.ua/d/uk/obyavlenie/uroki-vozhdeniya-dlya-zhenschin-avtoinstruktor-kiev-IDD7slb.html:578054345:0978072898
https://www.olx.ua/d/uk/obyavlenie/avtonstruktor-uroki-z-vodnnya-nstruktor-IDSVzso.html:811881468:0660545222
https://www.olx.ua/d/uk/obyavlenie/avtoinstruktor-avtomat-mehanika-IDUxZAj.html:835576375:0937990607
https://www.olx.ua/d/uk/obyavlenie/avtoinstruktor-avtonstruktor-pdvischennya-kvalfkats-kiv-ta-oblast-IDKHrhf.html:690064417:0968081617
https://www.olx.ua/d/uk/obyavlenie/instruktor-po-vozhdeniyu-avtonstruktor-privatn-uroki-vodnnya-IDQbhPV.html:771059648:0631680676
https://www.olx.ua/d/uk/obyavlenie/avtonstruktor-avtoshkola-IDUxmVo.html:835427828:+380961001514
https://www.olx.ua/d/uk/obyavlenie/uroki-vodnnya-avtonstruktor-IDTUZ2D.html:826279495:0969541599
https://www.olx.ua/d/uk/obyavlenie/avtoinstruktor-uroki-vozhdeniya-IDUxSNC.html:835550292:+380967119257
https://www.olx.ua/d/uk/obyavlenie/avtonstruktor-parkovka-mehanka-avtomat-IDNuR5W.html:731394403:0638842256
https://www.olx.ua/d/uk/obyavlenie/avtonstruktor-u-kropivnitskomu-pdgotovka-do-spitv-IDPtRbz.html:760709097:+380504871361
https://www.olx.ua/d/uk/obyavlenie/avtonstruktor-nstruktor-z-vodnnya-avtomoblem-privatn-uroki-IDSKOlp.html:809078759:+380999082207
https://www.olx.ua/d/uk/obyavlenie/avtonstruktor-privatn-uroki-vodnnya-kategor-v-IDUxqxz.html:835441665:0973179930
https://www.olx.ua/d/uk/obyavlenie/vozhdenie-vosstanovlenie-navykov-mehanika-i-avtomat-avtoinstruktor-IDLpvNn.html:700572061:0678758100
https://www.olx.ua/d/uk/obyavlenie/uroki-vodnnya-v-kiv-na-avtomat-avtonstruktor-IDOpcTZ.html:744824599:0938031712
https://www.olx.ua/d/uk/obyavlenie/avtoinstruktoravtomatchastnyy-instruktor-vozhdenie-avtouroki-IDOnbUU.html:744344156:+380939216404
https://www.olx.ua/d/uk/obyavlenie/avtonstruktor-akpp-mkpp-IDJHlrA.html:675265658:0931094753
https://www.olx.ua/d/uk/obyavlenie/avtoinstruktor-harkov-IDT5DkN.html:814041325:0505049101
https://www.olx.ua/d/uk/obyavlenie/instruktor-po-vozhdeniyu-v-nikolaeve-avtoinstruktor-uroki-vozhdeniya-IDDTXlK.html:589613288:0936878373
https://www.olx.ua/d/uk/obyavlenie/obuchenie-vozhdeniyu-avtomobilya-avtoinstruktor-IDIkmx9.html:655011967:0677106074
https://www.olx.ua/d/uk/obyavlenie/avtonstruktor-uroki-z-vodnnya-na-mehanchny-kpp-IDPaxX5.html:756106931:+380995116561
https://www.olx.ua/d/uk/obyavlenie/avtonstruktor-nstruktor-z-vodnnya-IDRuiWN.html:790368423:0992330591
https://www.olx.ua/d/uk/obyavlenie/avtonstruktor-nstruktor-z-vodnnya-privatn-uroki-z-vodnnya-IDSfDm2.html:801648346:0987070307
https://www.olx.ua/d/uk/obyavlenie/avtonstruktor-z-vodnnya-IDU7vve.html:829268118:0681275074
https://www.olx.ua/d/uk/obyavlenie/avtoinstruktor-instruktor-po-vozhdeniyu-chastnye-uroki-vozhdeniya-IDTMbS4.html:824183860:0977170350
https://www.olx.ua/d/uk/obyavlenie/instruktor-obuchenie-vozhdeniyu-na-akpp-avtoinstruktor-IDJqpGJ.html:671230397:0671311321
https://www.olx.ua/d/uk/obyavlenie/avtoinstruktor-so-svoimi-avto-IDTHVVu.html:823173162:0997229975
https://www.olx.ua/d/uk/obyavlenie/sertifitsirovannyy-avtoinstruktor-IDTqvIR.html:819020797:0675751795
https://www.olx.ua/d/uk/obyavlenie/avtonstruktor-na-mashin-uchnya-bezpechno-yaksno-IDUsIva.html:834319130:+380952772904
https://www.olx.ua/d/uk/obyavlenie/avtonstruktor-nstruktor-z-vodnnya-privatn-uroki-avtomat-IDNXDDt.html:738254179:+380997052086
https://www.olx.ua/d/uk/obyavlenie/uroki-vodnnya-avtonstruktor-IDQNHsS.html:780214626:0635170680
https://www.olx.ua/d/uk/obyavlenie/vozhdenie-avtoinstruktor-IDTuXky.html:820076390:0976869653
https://www.olx.ua/d/uk/obyavlenie/avtoinstruktor-po-vozhdeniyu-IDSrBzq.html:804501424:0956683302
https://www.olx.ua/d/uk/obyavlenie/avtonstruktor-nstruktor-z-vodnnya-IDUc83q.html:830365716:0930596373
https://www.olx.ua/d/uk/obyavlenie/uroki-vozhdeniya-mehanika-450grn-instruktor-po-vozhdeniyu-avtoinstruktor-IDDM5LX.html:587739041:0970128527
https://www.olx.ua/d/uk/obyavlenie/avtoinstruktor-kursy-vozhdeniya-instruktor-obuchenie-IDQ9fJZ.html:770574935:0933399298
https://www.olx.ua/d/uk/obyavlenie/vozhdenie-mehanika-avtomat-nstruktor-z-vodnnya-avtonstruktor-IDAk03Q.html:536714894:0686887070
https://www.olx.ua/d/uk/obyavlenie/instruktor-po-vozhdeniyu-IDTl5iS.html:817723758:0995536898
https://www.olx.ua/d/uk/obyavlenie/avtoinstruktor-obuchenie-vozhdeniyu-IDTqJ26.html:819068118:+380930242460
https://www.olx.ua/d/uk/obyavlenie/avtonstruktor-uroki-vodnnya-avtoshkola-nstruktor-IDQOd2D.html:780336007:+380955670083
https://www.olx.ua/d/uk/obyavlenie/avtonstruktor-nadayu-uroki-z-vodnnya-mayu-sertifkat-mayu-dosvt-roboi-IDUarhr.html:829962965:0636335533
https://www.olx.ua/d/uk/obyavlenie/avtoinstruktor-chastnye-uroki-vozhdeniya-instruktor-v-kieve-IDOxZzi.html:746918296:0951035534
https://www.olx.ua/d/uk/obyavlenie/vozhdenie-avtoinstruktor-instruktor-po-vozhdeniyu-mkpp-i-akpp-IDJLXZI.html:676367158:+380662081011
https://www.olx.ua/d/uk/obyavlenie/uslugi-avtoinstruktora-IDRtyvr.html:790190027:0937906908
https://www.olx.ua/d/uk/obyavlenie/avtoinstruktor-uroki-vozhdeniya-IDUhcau.html:831573170:0505234992
https://www.olx.ua/d/uk/obyavlenie/uroki-vodnnya-nstruktor-z-vodnnya-uroki-vozhdeniya-avtoinstruktor-IDIL0cU.html:661361000:0671681242
https://www.olx.ua/d/uk/obyavlenie/instruktor-avtoinstruktor-chastnye-uroki-vozhdeniya-IDLi3tj.html:698791045:0953193408
https://www.olx.ua/d/uk/obyavlenie/uroki-vozhdeniya-mehanika-avtomat-instruktor-po-vozhd-avtoinstruktor-IDJyqlg.html:673139534:0679802233
https://www.olx.ua/d/uk/obyavlenie/avtoinstruktor-uroki-vodnnya-obuchenie-vozhdeniyu-IDDqMM4.html:582661124:+380503255109
https://www.olx.ua/d/uk/obyavlenie/uroki-keruvannya-avtomoblem-avtomatichna-kpp-avtonstruktor-driving-i-IDIOZY3.html:662313391:+380964903159
https://www.olx.ua/d/uk/obyavlenie/avtonstruktor-avtoshkola-uroki-vodnnya-nstruktor-IDQOdh9.html:780336907:+380965585780
https://www.olx.ua/d/uk/obyavlenie/instruktor-po-vozhdeniyu-IDSutAo.html:805185716:0956683302
https://www.olx.ua/d/uk/obyavlenie/privatn-uroki-vodnnya-avtonstruktor-darnitsya-troschina-obolon-IDSOtLA.html:809952970:0978072898
https://www.olx.ua/d/uk/obyavlenie/avtoinstruktor-dlya-zhenschin-IDR0BxE.html:783290122:0933273120
https://www.olx.ua/d/uk/obyavlenie/avtoinstruktor-uroki-vozhdeniya-IDLixkj.html:698905807:0679293222
https://www.olx.ua/d/uk/obyavlenie/avtoinstruktor-kategoriya-v-avtomat-i-meh-IDTBXUs.html:821746912:0665699888
https://www.olx.ua/d/uk/obyavlenie/avtoinstruktor-obuchenie-chastnye-uroki-vozhdenie-instruktor-avtokursi-IDQ8srF.html:770385443:0933399298
https://www.olx.ua/d/uk/obyavlenie/instruktor-po-vozhdeniyu-avtoinstruktor-kursy-vozhdeniya-obuchenie-IDvgL88.html:476837172:095-245-25-75
https://www.olx.ua/d/uk/obyavlenie/avtonstruktor-uroki-vodnnya-nstruktor-z-vodnnya-IDRhquq.html:787299214:+380663625378
https://www.olx.ua/d/uk/obyavlenie/avtoinstruktor-uroki-vozhdeniya-kursy-vozhdeniya-instruktor-po-vozhdeniyu-IDREJpz.html:792853493:098-450-74-74
https://www.olx.ua/d/uk/obyavlenie/uroki-vodnnya-lviy-bereg-kiv-IDS9KPA.html:800247118:0953884648
https://www.olx.ua/d/uk/obyavlenie/avtoshkola-avtoinstruktor-uroki-vozhdeniya-chernigov-IDL04nu.html:694504624:0631891224
https://www.olx.ua/d/uk/obyavlenie/nstruktor-z-vodnnya-avtonstruktor-uroki-vodnnya-avtoinstruktor-IDSzhbG.html:806329696:0731008050
https://www.olx.ua/d/uk/obyavlenie/uroki-vozhdeniya-600grn-1-5-chasa-avtoinstruktor-IDrtrxS.html:405978472:0675391617
https://www.olx.ua/d/uk/obyavlenie/instruktor-po-vozhdeniyu-avtoinstruktor-IDTc8pD.html:815590757:0954092003
https://www.olx.ua/d/uk/obyavlenie/instruktor-po-vozhdeniyu-mkpp-obuchayu-vozhdeniyu-IDSRqB4.html:810655770:0673259510
https://www.olx.ua/d/uk/obyavlenie/instruktor-po-vozhdeniyu-uroki-vozhdeniya-po-gorodu-avtoinstruktor-IDJAdrg.html:673566590:0676080096
https://www.olx.ua/d/uk/obyavlenie/avtoinstruktor-instruktor-po-vozhdeniyu-IDT2fS8.html:813236152:0951219798
https://www.olx.ua/d/uk/obyavlenie/uroki-vozhdeniya-na-vashem-avto-s-opytnym-avtoinstruktorom-IDvjSxQ.html:477580658:+380667677236
https://www.olx.ua/d/uk/obyavlenie/avtoinstruktor-mkpp-pdgotovka-do-spitu-nstruktor-z-vodnnya-IDQnIte.html:774021964:+380683579833
https://www.olx.ua/d/uk/obyavlenie/avtoinstruktor-harkov-uroki-vozhdeniya-avtomoticheskaya-mehanicheskaya-kp-IDLDMj1.html:703968275:+380678005570
https://www.olx.ua/d/uk/obyavlenie/avtoinstruktor-chastnye-uroki-vozhdeniya-instruktor-avtoshkola-IDRVwJH.html:797090829:+380635335373
https://www.olx.ua/d/uk/obyavlenie/avtoinstruktor-dlya-devushek-IDOJijW.html:749611987:0933273120
https://www.olx.ua/d/uk/obyavlenie/avtoinstruktor-uroki-vozhdeniya-IDUcA4b.html:830473395:+380990026669
https://www.olx.ua/d/uk/obyavlenie/instruktor-po-vozhdeniyu-harkov-avtoinstruktor-mehanika-IDR9uDw.html:785408529:0501026118
https://www.olx.ua/d/uk/obyavlenie/avtoinstruktor-poltava-profesional-voditel-uroki-vozhdeniya-IDBUrkT.html:560175883:0992888401
https://www.olx.ua/d/uk/obyavlenie/vozhdenie-avtoinstruktor-IDSUaK0.html:811309804:0665790655
https://www.olx.ua/d/uk/obyavlenie/obuchenie-vozhdeniyu-na-avtomaticheskoy-kpp-avtoinstruktor-IDIJcXb.html:660933341:+380963902350
https://www.olx.ua/d/uk/obyavlenie/avtoinstrukor-instruktor-po-vozhdeniyu-mkpp-500-grn-IDQl8yR.html:773407273:0688009810
https://www.olx.ua/d/uk/obyavlenie/uroki-vodnnya-nstruktor-z-vodnnya-uroki-vozhdeniya-avtoinstruktor-IDJ1W6W.html:665392985:0671681242
https://www.olx.ua/d/uk/obyavlenie/uroki-vozhdeniya-avtoinstruktor-akpp-dnepr-IDTz1kw.html:821045075:+380930295354
https://www.olx.ua/d/uk/obyavlenie/avtoinstruktor-instruktor-po-vozhdeniyu-IDSC9Xm.html:807016884:+380936402601
https://www.olx.ua/d/uk/obyavlenie/avtoinstruktor-instruktor-po-vozhdeniyu-uroki-vozhdeniya-IDK9x9D.html:681983857:+380990091333
https://www.olx.ua/d/uk/obyavlenie/avtoinstruktor-uroki-vozhdeniya-obuchenie-vozhdeniyu-instruktor-IDT98Hy.html:814876884:0933399298
https://www.olx.ua/d/uk/obyavlenie/uroki-vozhdeniya-avtoinstruktor-kiev-IDQfcB5.html:771992819:093 183 1308
https://www.olx.ua/d/uk/obyavlenie/instruktor-obuchenie-vozhdeniyu-mehanika-avtoinstruktor-uroki-vozhdeniya-IDRgttX.html:787072389:050 330 5484
https://www.olx.ua/d/uk/obyavlenie/nstruktor-z-keruvannya-boyarka-vishneve-sofb-avtonstruktor-IDhjun6.html:255842696:0959494150
https://www.olx.ua/d/uk/obyavlenie/avtoinstruktor-po-vozhdeniyu-kiev-oblast-IDOxGbJ.html:746843799:0636090373
https://www.olx.ua/d/uk/obyavlenie/uroki-vozhdeniya-avtoinstruktor-IDE6xhj.html:592611333:+380677823984
https://www.olx.ua/d/uk/obyavlenie/privatn-uroki-vodnnya-avtonstruktor-vodnnya-lvv-IDT79Bf.html:814403681:+380981812002
https://www.olx.ua/d/uk/obyavlenie/avtonstruktor-lvv-privatn-uroki-vodnnya-ta-kursi-vodv-IDRWd7L.html:796780957:+380981812002
https://www.olx.ua/d/uk/obyavlenie/uroki-vozhdeniya-avtoinstruktor-instruktor-vozhdeniya-300-grn-chas-IDIvGXP.html:657950437:+380681561258
https://www.olx.ua/d/uk/obyavlenie/avtoshkola-avtoinstruktor-IDTivAc.html:817113636:0988770700
https://www.olx.ua/d/uk/obyavlenie/avtoinstruktor-kiev-avtonstruktor-kiv-uroki-vozhdeniya-IDTp5Ud.html:818679385:0507763953
https://www.olx.ua/d/uk/obyavlenie/uroki-vodnnya-kiv-avtonstruktor-vodnnya-nstruktor-IDUs2mC.html:834157090:0933399298
https://www.olx.ua/d/uk/obyavlenie/poslugi-avtonstruktora-uroki-vodnnya-IDT02x9.html:812708223:0972783789
https://www.olx.ua/d/uk/obyavlenie/avtonstruktor-akpp-mkpp-avtoshkola-dodatkov-zanyattya-z-vodnnya-IDBOiOx.html:558713157:+380689385617
https://www.olx.ua/d/uk/obyavlenie/avtoinstruktor-avtonstruktor-uroki-vozhdeniya-privatn-uroki-IDGRyvR.html:633370229:0985987575
https://www.olx.ua/d/uk/obyavlenie/nstruktor-z-vodnnya-privatn-uroki-vodnnya-avtonstruktor-IDKvhCM.html:687405704:+380964826843
https://www.olx.ua/d/uk/obyavlenie/instruktor-po-vozhdeniyu-avtoinstruktor-kursy-vozhdeniya-chastnye-uroki-IDO4iAx.html:739841569:0992057070
https://www.olx.ua/d/uk/obyavlenie/nstruktor-z-vodnnya-avtoinstruktor-avtoshkola-uroki-vozhdeniya-IDUv0VK.html:835104954:0664314380
https://www.olx.ua/d/uk/obyavlenie/uroki-vodnnya-kat-v-privatniy-avtonstruktor-nstruktor-psiholog-IDUvAby.html:835240412:0997055806
https://www.olx.ua/d/uk/obyavlenie/uroki-vodnnyakursi-z-vodnnya-avtoavtonstruktor-lutsk-IDTYgef.html:827060547:0954143135
https://www.olx.ua/d/uk/obyavlenie/avtoinstruktor-kiev-instruktor-po-vozhdeniyu-uroki-vozhdeniya-IDQbxhk.html:771119006:0937480089
https://www.olx.ua/d/uk/obyavlenie/uroki-vozhdeniya-avtoinstruktor-IDUBOhc.html:836486218:0502090580
https://www.olx.ua/d/uk/obyavlenie/instruktor-po-vozhdeniyu-na-vashem-avto-avtoinstruktor-v-s-IDRz3a5.html:791499445:0636768846
https://www.olx.ua/d/uk/obyavlenie/avtoinstruktor-uroki-vozhdeniya-IDFUWIv.html:619398012:+380961714085
https://www.olx.ua/d/uk/obyavlenie/dayu-uroki-vozhdeniya-avtoinstruktor-IDR9sLA.html:785401342:+380951995400
https://www.olx.ua/d/uk/obyavlenie/avtoinstruktor-kategoriya-s-IDUpNid.html:833622501:+380501570939
https://www.olx.ua/d/uk/obyavlenie/instruktor-po-vozhdeniyu-harkov-avtoinstruktor-mehanika-harkov-IDRiyvx.html:787568425:+380501026118
https://www.olx.ua/d/uk/obyavlenie/avtonstruktor-IDUBWMI.html:836515080:0960908008
https://www.olx.ua/d/uk/obyavlenie/chastnye-uroki-vozhdeniya-avtomat-avtoinstruktor-instruktor-po-vozhdeniyu-IDjX1vc.html:294817576:0938031712
https://www.olx.ua/d/uk/obyavlenie/chastnye-uroki-vozhdeniya-instruktor-po-vozhdeniyu-avtoinstruktor-IDgflwM.html:240078990:0989160953
https://www.olx.ua/d/uk/obyavlenie/avtoinstruktor-chastnye-uroki-vozhdeniya-avtomobilya-instruktor-v-kieve-IDOxxNs.html:746811542:067-908-44-54
https://www.olx.ua/d/uk/obyavlenie/privatniy-avtonstruktor-IDTHSEJ.html:823156685:0956683302
https://www.olx.ua/d/uk/obyavlenie/avtoinstruktor-avtoshkola-uroki-vozhdeniya-avtomat-mehanika-IDFtcMN.html:612790441:0686707772
https://www.olx.ua/d/uk/obyavlenie/avtoinstruktor-obuchenie-kursy-vozhdeniya-instruktor-IDQ9gQW.html:770579209:0933399298
https://www.olx.ua/d/uk/obyavlenie/avtonstruktor-mehanka-privatn-ta-ndivdualn-uroki-avtoshkola-IDTQHMp.html:825259829:0933763313
https://www.olx.ua/d/uk/obyavlenie/avtonstruktor-z-vodnnya-avto-uroki-mehanka-mkpp-IDJoqTW.html:670758403:+380633413344
https://www.olx.ua/d/uk/obyavlenie/avtonstruktor-privatn-uroki-avtoshkola-IDTRJzJ.html:825505059:+380633293405
https://www.olx.ua/d/uk/obyavlenie/instruktor-po-vozhdeniyu-avtoinstruktor-akpp-mkpp-uroki-vozhdeniya-IDLyCs5.html:702738757:0637015653
https://www.olx.ua/d/uk/obyavlenie/nstruktor-z-vodnnya-avtonstruktor-instruktor-po-vozhdeniyu-IDUrkdK.html:833987404:0970010131
https://www.olx.ua/d/uk/obyavlenie/nstruktor-z-vodnnya-avtonstruktor-vodnnya-mkpp-akpp-avtomat-mehanka-IDTNxbY.html:824504146:0673635657
https://www.olx.ua/d/uk/obyavlenie/avtoinstruktor-chastnye-uroki-obuchenie-vozhdeniyu-uroki-vozhdeniya-IDPqi2V.html:759859038:+380665882406
https://www.olx.ua/d/uk/obyavlenie/avtonstruktor-na-vashomu-avto-mehanka-avtomat-troschina-IDPGS0E.html:763810528:0675222813
https://www.olx.ua/d/uk/obyavlenie/nstruktor-po-vodnnyu-avtonstruktor-uroki-kermuvannya-na-vashomu-avto-IDTFMef.html:822655323:098-220-22-02
https://www.olx.ua/d/uk/obyavlenie/avtonstruktor-kategorya-s-IDU8xvo.html:829510300:+380638977118
https://www.olx.ua/d/uk/obyavlenie/chastnye-uroki-vozhdeniya-avtoinstruktor-instruktor-po-vozhdeniyu-IDRDsYJ.html:792551997:+380663060638
https://www.olx.ua/d/uk/obyavlenie/avtoinstruktor-harkov-instruktor-po-vozhdeniyu-mehanika-IDQnufC.html:773967304:+380501026118
https://www.olx.ua/d/uk/obyavlenie/uroki-vozhdeniya-avtoinstruktor-IDwr9tO.html:464537716:0673167368
https://www.olx.ua/d/uk/obyavlenie/avtoinstruktor-uroki-vozhdeniya-avtomat-privatniy-avtonstruktor-IDOtqiD.html:745829411:0985987575
https://www.olx.ua/d/uk/obyavlenie/avtonstruktor-uroki-vodnnya-IDTJdBd.html:823475519:0968189193
https://www.olx.ua/d/uk/obyavlenie/uroki-vozhdeniya-avtoinstruktor-IDPVJno.html:767590590:0733331007
https://www.olx.ua/d/uk/obyavlenie/avtonstruktor-privatn-uroki-vodnnya-IDSikIw.html:802291687:+380981812002
https://www.olx.ua/d/uk/obyavlenie/uroki-vodnnya-avtonstruktor-privatn-uroki-IDOjdUg.html:743398492:0631227115
https://www.olx.ua/d/uk/obyavlenie/avtonstruktor-nstruktor-z-vodnnya-mkpp-IDT9JgM.html:815017452:0987643797
https://www.olx.ua/d/uk/obyavlenie/avtonstruktor-privatn-uroki-kursi-vodnnya-nstruktor-z-vodnnya-IDPSSWu.html:766673988:+380981812002
https://www.olx.ua/d/uk/obyavlenie/uroki-vozhdeniya-instruktor-po-vozhdeniyu-avtoshkola-avtoinstruktor-IDPBMNe.html:762598836:+380502470410
https://www.olx.ua/d/uk/obyavlenie/avtoinstruktor-instruktor-po-vozhdeniyu-avtoshkola-chastnye-uroki-avtonst-IDSOloK.html:809920802:0665577171
https://www.olx.ua/d/uk/obyavlenie/vozhdenie-instruktor-po-vozhdeniyu-avtoinstruktor-avtomat-dzhip-IDJ29T6.html:665449788:0939909910
https://www.olx.ua/d/uk/obyavlenie/avtoinstruktor-chastnye-uroki-vozhdeniya-instruktor-v-kieve-IDOKWlE.html:750000338:067-908-44-54
https://www.olx.ua/d/uk/obyavlenie/avtoinstruktor-uroki-vozhdeniya-kursy-vozhdeniya-IDQ8Pgn.html:770473155:0934951481
https://www.olx.ua/d/uk/obyavlenie/avtoinstruktor-obuchenie-vozhdeniyu-IDRhHwt.html:787364627:0972147202
https://www.olx.ua/d/uk/obyavlenie/chastnyy-avtoinstruktor-instruktor-po-vozhdeniyu-avtoshkola-IDP2AYh.html:754211913:+380635335373
https://www.olx.ua/d/uk/obyavlenie/avtonstruktor-uroki-vodnnya-z-0-IDTLrWY.html:824007278:0500327270
https://www.olx.ua/d/uk/obyavlenie/avtonstruktorprivatn-uroki-navchannyanstruktornavchannya-vodnnya-IDCupuU.html:568748624:067-633-6138
https://www.olx.ua/d/uk/obyavlenie/privatniy-nstruktor-z-vodnnya-avtonstruktor-avtoshkola-IDTkXAj.html:817694087:+380635335373
https://www.olx.ua/d/uk/obyavlenie/privatn-uroki-uroki-vodnnya-avtonstruktor-nstruktor-z-vodnnya-IDEo4id.html:596789817:+380687417397
https://www.olx.ua/d/uk/obyavlenie/avtonstruktor-navchannya-vodnnyu-IDTtmtd.html:819696371:068 778 0077
https://www.olx.ua/d/uk/obyavlenie/nstruktor-z-vodnnya-navchannya-vodnnyu-uroki-vodnnya-privatniy-nst-IDSyUb3.html:806241245:+380665882406
https://www.olx.ua/d/uk/obyavlenie/avtonstruktor-privatn-uroki-vodnnya-na-avtomobl-mototsikl-IDQ4mKl.html:769410225:0980707076
https://www.olx.ua/d/uk/obyavlenie/avtoinstruktor-chastnye-uroki-vozhdeniya-avtomobilya-IDzVToM.html:531207740:+380501570939
https://www.olx.ua/d/uk/obyavlenie/instruktor-kiev-avtonstruktor-kiv-uroki-vodnnya-IDH2ViG.html:636083214:0637400382
https://www.olx.ua/d/uk/obyavlenie/avtoinstruktor-instruktor-po-vozhdeniyu-IDIGPgz.html:660365631:0965670888
https://www.olx.ua/d/uk/obyavlenie/avtonstruktor-uroki-vodnnya-IDKm3h8.html:684967266:0673894888
https://www.olx.ua/d/uk/obyavlenie/avtonstruktor-nstruktor-z-vodnnya-avtoshkola-privatn-uroki-vodnnya-IDSm0KD.html:803168251:093 919 9515
https://www.olx.ua/d/uk/obyavlenie/avtoinstruktor-chastnye-uroki-vozhdeniya-instruktor-v-kieve-IDOAK9W.html:747574047:095-103-55-34
https://www.olx.ua/d/uk/obyavlenie/avtonstruktor-avtomobl-z-korobkoyu-avtomat-800grn-90hv-IDUrUzj.html:834127125:+380506883246
https://www.olx.ua/d/uk/obyavlenie/avtoinstruktor-obuchenie-vozhdeniyu-IDSVUSN.html:811963829:0930242460
https://www.olx.ua/d/uk/obyavlenie/avtonstruktor-uroki-z-vodnnya-IDTheqZ.html:816805545:0934951314
https://www.olx.ua/d/uk/obyavlenie/avtonstruktor-vodnnya-uroki-vodnnya-privatniy-nstruktor-IDSWstM.html:811616318:0933399298
https://www.olx.ua/d/uk/obyavlenie/instruktor-po-vozhdeniyu-obuchenie-avtovozhdeniyu-uroki-vozhdeniya-mkpp-IDU2RJa.html:828158004:+380974406766
https://www.olx.ua/d/uk/obyavlenie/avtoinstruktor-uroki-vozhdeniya-instruktor-vozhdeniya-mehanika-levyy-bereg-IDK8xNB.html:681748007:+380639899114
https://www.olx.ua/d/uk/obyavlenie/nstruktor-z-vodnnya-instruktor-s-vozhdeniya-avtoinstruktor-IDUyPZP.html:835777845:0507202849
https://www.olx.ua/d/uk/obyavlenie/instruktor-po-vozhdeniyu-vozhdenie-na-vashem-avto-avtoinstruktor-poltava-IDKWVmG.html:693520510:0997617412
https://www.olx.ua/d/uk/obyavlenie/avtoinstruktor-v-kieve-obolon-minskiy-vinogradar-i-drugie-rayony-IDQ6IsR.html:769970365:0674047174
https://www.olx.ua/d/uk/obyavlenie/instruktor-po-vozhdeniyu-uroki-vozhdeniya-avtoinstruktor-na-vashem-avto-IDEkW72.html:596039544:098-220-22-02
https://www.olx.ua/d/uk/obyavlenie/uroki-vozhdeniya-dnepr-avtoinstruktor-IDBXgHE.html:560849994:0674263709
https://www.olx.ua/d/uk/obyavlenie/avtonstruktor-harkv-privatn-uroki-vodnnya-mehanka-IDRNqch.html:794924585:0501026118
https://www.olx.ua/d/uk/obyavlenie/avtoinstruktor-uroki-vozhdeniya-na-akppavtomat-IDLDHT3.html:703951289:+380678005570
https://www.olx.ua/d/uk/obyavlenie/instruktor-po-vozhdeniyu-avtoinstruktor-uroki-vozhdeniya-avtoshkola-IDuX2V6.html:457362722:+380502470410
https://www.olx.ua/d/uk/obyavlenie/avtonstruktor-privatn-uroki-kursi-vodnnya-IDRZBWQ.html:797829630:+380981812002
https://www.olx.ua/d/uk/obyavlenie/nstruktor-z-vodnnya-instruktor-po-vozhdeniyu-avtonstruktor-IDQKxPX.html:779462633:0675514878
https://www.olx.ua/d/uk/obyavlenie/avtoinstruktor-obuchenie-vozhdeniyu-uroki-kursy-vozhdeniya-obuchenie-IDQ9gAH.html:770578203:0933399298
https://www.olx.ua/d/uk/obyavlenie/avtonstruktor-vs-rayoni-odesi-navchannya-vodnnyu-IDOj6wJ.html:743370063:066-92-16-16-2
https://www.olx.ua/d/uk/obyavlenie/avtonstruktor-kiv-uroki-vodnnya-avtoshkola-IDTnko0.html:818258392:+380960359602
https://www.olx.ua/d/uk/obyavlenie/avtoinstruktor-instruktor-po-vozhdeniyu-kursy-vozhdeniya-chastnye-uroki-IDNOe4C.html: 736010966:+380502470410
https://www.olx.ua/d/uk/obyavlenie/avtonstruktor-kiv-osokorki-poznyaki-uroki-vodnnya-avtoshkola-IDHwMFf.html:642957685:+380960359602
https://www.olx.ua/d/uk/obyavlenie/nstruktor-z-vodnnya-avtonstruktor-uroki-vodnnya-avtoinstruktor-IDR6dxI.html:784627838:0731008050
https://www.olx.ua/d/uk/obyavlenie/chastnye-uroki-vozhdeniya-avtoinstruktor-mehanika-instruktor-po-vozhdeniyu-IDRMQdz.html:794786281:0501026118
https://www.olx.ua/d/uk/obyavlenie/avtonstruktor-avtomat-avtoshkola-nstruktor-vozhdenie-IDUcP2P.html:830530971:+380969394454
https://www.olx.ua/d/uk/obyavlenie/avtonstruktor-nstruktor-z-vodnnya-avtomoblya-mehanka-IDR18Dm.html:783417328:0501026118
https://www.olx.ua/d/uk/obyavlenie/avtonstruktor-vodnnya-avto-IDUAvXg.html:836181306:0990026669
https://www.olx.ua/d/uk/obyavlenie/avtoinstruktor-instruktor-po-vozhdeniyu-avtoshkola-chastnye-uroki-vozhdeniya-IDSlUnr.html:803143749:0939199515
https://www.olx.ua/d/uk/obyavlenie/avtonstruktor-privatn-zanyattya-uroki-vodnnya-IDOqbpm.html:745057184:0672588338
https://www.olx.ua/d/uk/obyavlenie/avtonstruktor-lvvsko-avto-shkoli-uroki-vodnnya-IDOj5rr.html:743365953:+380939320200
https://www.olx.ua/d/uk/obyavlenie/avtoinstruktor-uroki-vozhdeniya-IDPdpeX.html:756788427:0931409856
https://www.olx.ua/d/uk/obyavlenie/nstruktor-z-vodnnya-avtonstruktor-IDLKcNu.html:705500076:0637307375
https://www.olx.ua/d/uk/obyavlenie/avtonstruktor-vdnovlennya-navichok-IDK4h6q.html:680730514:0678605735
https://www.olx.ua/d/uk/obyavlenie/kursi-vodv-avtonstruktor-nstruktor-z-vodnnya-IDPQADS.html:766127048:+38 099 4900492
https://www.olx.ua/d/uk/obyavlenie/avtonstruktor-nstruktor-z-vodnnya-avtoshkola-IDTkXLU.html:817694806:+380635335373
https://www.olx.ua/d/uk/obyavlenie/navchayu-voditi-avto-avtonstruktor-na-sertifkovanomu-avto-avtoshkola-IDUyBvz.html:835722215:0979131447
https://www.olx.ua/d/uk/obyavlenie/instruktor-po-vozhdeniyu-avtoinstruktor-kursy-vozhdeniya-obuchenie-IDITQhv.html:663467798:095-245-25-75
https://www.olx.ua/d/uk/obyavlenie/avtonstruktor-uroki-vodnnya-akpp-mkpp-IDSMXca.html:809589438:+380959015560
https://www.olx.ua/d/uk/obyavlenie/avtoinstruktor-vozhdenie-kiev-avtoshkola-instruktor-po-vozhdeniyu-IDUs2Ua.html:834159170:0933399298
https://www.olx.ua/d/uk/obyavlenie/uroki-vozhdeniya-avtomobilya-instruktor-po-vozhdeniyu-avtoinstruktor-IDbtyNf.html:169584957:+380955235998
https://www.olx.ua/d/uk/obyavlenie/avtonstruktor-uroki-vodnnya-na-darnits-ta-troschin-IDTauxm.html:815199148:0978072898
https://www.olx.ua/d/uk/obyavlenie/obuchenie-vozhdeniyu-avtomobilya-IDP42IL.html:754556911:0730738348
https://www.olx.ua/d/uk/obyavlenie/avtoinstruktor-instruktor-po-vozhdeniyu-avtotrener-IDUoB3h.html:833337119:+380996221347
https://www.olx.ua/d/uk/obyavlenie/privatniy-nstruktor-avtonstruktor-ndivdualn-uroki-vodnnya-IDRjk5b.html:787751241:0939199515
https://www.olx.ua/d/uk/obyavlenie/avtonstruktor-uroki-vodnnya-nstruktor-z-vodnnya-IDQTg7K.html:781539496:0675448968
https://www.olx.ua/d/uk/obyavlenie/uroki-vozhdeniya-mehanika-na-daewoo-lanos-avtoinstruktor-levyy-bereg-IDsyjhq.html:421914676:0638885216
https://www.olx.ua/d/uk/obyavlenie/obuchenie-uroki-po-vozhdeniyu-avtomobilem-kat-v-d-avtoshkola-alyans-IDQxUGi.html:776452182:050-362-61-81
https://www.olx.ua/d/uk/obyavlenie/instruktor-obuchenie-vozhdeniyu-na-akpp-avtoinstruktor-IDLivjI.html:698901926:0963902350
https://www.olx.ua/d/uk/obyavlenie/instruktor-po-vozhdeniyu-dnepr-IDRoEN6.html:789022484:0968344884
https://www.olx.ua/d/uk/obyavlenie/avtonstruktor-privatn-uroki-vodnnya-nstruktor-z-vodnnya-IDEqLcI.html:597431424:0738095052
https://www.olx.ua/d/uk/obyavlenie/nstruktor-z-vodnnya-avtonstruktor-uroki-vodnnya-avtoinstruktor-IDQlSiY.html:773583112:0731008050
https://www.olx.ua/d/uk/obyavlenie/nstruktor-z-vodnnya-avtonstruktor-avtoinstruktor-IDSXTFd.html:812197471:+380978464275
https://www.olx.ua/d/uk/obyavlenie/avtoinstruktor-harkov-instruktor-po-vozhdeniyu-mehanika-avtoinstruktor-IDMOHS5.html:721349173:0501026118
https://www.olx.ua/d/uk/obyavlenie/nstruktor-z-vodnnya-avtonstruktor-vodnnya-avtomatichna-korobka-akpp-IDTpq9h.html:818757199:0673635657
https://www.olx.ua/d/uk/obyavlenie/avtonstruktor-avtoshkola-rega-u-lvov-podarunkov-sertifkati-IDFByTt.html:614782047:098 444 1240
https://www.olx.ua/d/uk/obyavlenie/kursi-vodnnya-avtonstruktor-avtoshkola-avtomat-mehanka-IDRr50x.html:789599917:0674392847
https://www.olx.ua/d/uk/obyavlenie/avtonstruktor-nstruktor-z-vodnnya-avtoshkola-privatn-uroki-vodnnya-IDSlWHK.html:803148852:0939199515
https://www.olx.ua/d/uk/obyavlenie/avtonstruktor-uroki-z-vodnnya-IDSaSzW.html:800515227:0968687160
https://www.olx.ua/d/uk/obyavlenie/privatniy-avtonstruktor-chastnye-uroki-vozhdeniya-IDFNpIz.html:617606711:+380939216404
https://www.olx.ua/d/uk/obyavlenie/kursy-po-vozhdeniyu-na-gruzovyh-avto-c-ce-s-luchshim-instruktorom-IDT8FiX.html:814763883:0674392847
https://www.olx.ua/d/uk/obyavlenie/avtoinstruktor-uroki-po-vozhdeniyu-instruktor-po-vozhdeniyu-IDRb9lp.html:785803339:0997922802
https://www.olx.ua/d/uk/obyavlenie/avtoinstruktor-uroki-vozhdeniya-v-kieve-akpp-ili-na-vashem-avto-IDMY2WZ.html:723575091:0674047174
https://www.olx.ua/d/uk/obyavlenie/avtonstruktor-nstruktor-z-vodnnya-avtoshkola-privatn-uroki-vodnnya-IDUrxin.html:834037663:0939199515
https://www.olx.ua/d/uk/obyavlenie/nstruktor-z-vodnnya-avtonstruktor-IDUuR1J.html:834828495:0994768676
https://www.olx.ua/d/uk/obyavlenie/instruktor-po-vozhdeniyu-avtoinstruktor-IDaC58F.html:156839581:0682010092
https://www.olx.ua/d/uk/obyavlenie/avtonstruktor-r-n-borschagvka-rpn-bucha-borodyanka-IDTBmOk.html:821604304:0982558672
https://www.olx.ua/d/uk/obyavlenie/uroki-profesynogo-nstruktora-z-vodnnya-IDG9dQZ.html:622804321:+380634544305
https://www.olx.ua/d/uk/obyavlenie/uroki-vodnnya-nstruktor-z-vodnnya-uroki-vozhdeniya-avtoinstruktor-IDJ1VEf.html:665398895:0671681242
https://www.olx.ua/d/uk/obyavlenie/avtonstruktor-privatn-uroki-vodnnya-kursi-vodv-lvv-IDT79LK.html:814404332:+380981812002
https://www.olx.ua/d/uk/obyavlenie/uroki-vodnnya-dlya-zhnok-avtonstruktor-kiv-IDTa53S.html:815101220:0953884648
https://www.olx.ua/d/uk/obyavlenie/avtoinstruktor-harkov-instruktor-po-vozhdeniyu-mehanika-IDQDD8W.html:777814733:0501026118
https://www.olx.ua/d/uk/obyavlenie/uroki-vozhdeniya-obolon-minskiy-massiv-IDMvYG1.html:717123869:+380502227697
https://www.olx.ua/d/uk/obyavlenie/avtonstruktor-nstruktor-z-vodnnya-avto-IDtrFFA.html:435108782:0979111038
https://www.olx.ua/d/uk/obyavlenie/avtonstruktor-nstruktor-z-vodinnya-us-rayoni-kiva-IDSuZyn.html:805308599:0939199515
https://www.olx.ua/d/uk/obyavlenie/avtonstruktor-kat-v-IDPW67w.html:767201361:+380679812515
https://www.olx.ua/d/uk/obyavlenie/tvereziy-vody-trezviy-voditel-ns-driver-peregon-avto-kupvlya-prodazh-IDIXpfL.html:664317213:0966256899
https://www.olx.ua/d/uk/obyavlenie/avtonstruktor-uroki-vodnnya-keruvannya-avtomoblya-avto-nstruktor-IDJ87Ks.html:666871532:0677722688
https://www.olx.ua/d/uk/obyavlenie/uroki-vozhdeniya-na-avtomobile-s-akpp-instruktor-po-vozhdeniyu-ID8aatl.html:120634227:097-260-43-95
https://www.olx.ua/d/uk/obyavlenie/avtonstruktor-dosvd-blshe-30-rokv-IDSy846.html:806056302:0952869988
https://www.olx.ua/d/uk/obyavlenie/chastnyy-instruktor-po-vozhdeniyu-vozhdenie-avtoinstruktor-uroki-vozhdeniya-IDKNFYI.html:691550896:063-650-6264
https://www.olx.ua/d/uk/obyavlenie/avtonstruktor-nstruktor-z-vodnnya-IDTtRXp.html:819817407:0667193959
https://www.olx.ua/d/uk/obyavlenie/kursi-vodnnya-avtomat-mehanka-avtonstruktor-avtoshkola-IDSVlJn.html:811828705:0931801177
https://www.olx.ua/d/uk/obyavlenie/instruktor-po-vozhdeniyu-vosstanovlenie-navykov-po-samym-nizkim-tsenam-IDtfpwc.html:432186698:0988892742
https://www.olx.ua/d/uk/obyavlenie/uroki-vdnovlennya-ta-vdoskonalennya-navikv-vodnnya-IDTLs8h.html:824008041:0677192273
https://www.olx.ua/d/uk/obyavlenie/nstruktor-z-vodnnya-avtomoblya-IDIVEPP.html:664138781:0681348504
https://www.olx.ua/d/uk/obyavlenie/navchannya-vodnnyu-avtonstruktor-avtoshkola-mehanka-abo-avtomat-IDRr4M9.html:789599025:0674392847
https://www.olx.ua/d/uk/obyavlenie/avtoinstruktor-horosho-obuchu-vozhdeniyu-na-avtomobile-IDjaaw0.html:283174026:0635563762
https://www.olx.ua/d/uk/obyavlenie/uroki-vodnnya-avtomat-mehanka-avtoshkola-avtonstruktor-IDRr2dg.html:789589174:0674392847
https://www.olx.ua/d/uk/obyavlenie/uroki-vodnnya-avtoshkola-mehanka-avtomat-avtonstruktor-z-vodnnya-IDSVlca.html:811826646:0931801177
https://www.olx.ua/d/uk/obyavlenie/chastnye-uroki-vozhdeniya-akpp-i-mkpp-IDMo0L7.html:714986921:0988855359
https://www.olx.ua/d/uk/obyavlenie/instruktor-po-vozhdeniyu-dlya-devushek-IDRgy9n.html:787090333:0933273120
https://www.olx.ua/d/uk/obyavlenie/avtonstruktor-IDUfkUZ.html:831130149:0500495564
https://www.olx.ua/d/uk/obyavlenie/avtonstruktor-nstruktor-z-vodnnya-avtomoblya-IDSBrRu.html:806847384:0674617188
https://www.olx.ua/d/uk/obyavlenie/uroki-vozhdeniya-akpp-obuchenie-vozhdeniyu-v-lyubom-rayone-kieva-IDRGdhs.html:793206638:0952085184
https://www.olx.ua/d/uk/obyavlenie/mehanika-uroki-vozhdeniya-IDT6pBi.html:814226860:+380991178022
https://www.olx.ua/d/uk/obyavlenie/kursi-vodv-avtonstruktor-mehanka-ta-avtomat-avtoshkola-IDSVkVb.html:811825655:0931801177
https://www.olx.ua/d/uk/obyavlenie/uroki-vozhdeniya-mehanika-instruktor-po-vozhdeniyu-avtoinstruktor-dnepr-IDOwGNh.html:746369471:0665785871
https://www.olx.ua/d/uk/obyavlenie/nstruktor-z-vodnnya-avtonstruktor-uroki-vodnnya-IDSVXuG.html:811973866:+380951011003
https://www.olx.ua/d/uk/obyavlenie/avtonstruktor-u-lvov-nstruktor-z-vodnnya-privatn-uroki-vodnnya-IDv6vNy.html:474398800:+380677702040
https://www.olx.ua/d/uk/obyavlenie/avtonstruktor-yaksne-navchanya-v-spokyny-atmosfer-IDU5C4A.html:828812812:+380633756275
https://www.olx.ua/d/uk/obyavlenie/avtoinstruktor-instruktor-po-vozhdeniyu-obuchenie-vozhdeniyu-avtomat-IDJX9XA.html:679034762:+380960696608
https://www.olx.ua/d/uk/obyavlenie/avtonstruktor-privatn-uroki-akpp-mkpp-instruktor-psiholog-IDUvArx.html:835241403:0997055806
https://www.olx.ua/d/uk/obyavlenie/uroki-vozhdeniya-dlya-zhenschin-avtoinstruktor-zhenschina-IDISeqS.html:663083978:0505407050
https://www.olx.ua/d/uk/obyavlenie/avtonstruktor-IDTFRvq.html:822675670:0990098883
https://www.olx.ua/d/uk/obyavlenie/instruktor-po-vozhdeniyu-uroki-vozhdeniya-avtoinstruktor-IDSEnby.html:807544392:0964729314
https://www.olx.ua/d/uk/obyavlenie/uroki-vozhdeniya-avtoinstruktor-instruktor-po-vozhdeniyu-IDSEyO3.html:807589063:0669001848
https://www.olx.ua/d/uk/obyavlenie/uroki-po-vodnnyu-mehanka-avtomat-IDTVTul.html:826734805:0971763325
https://www.olx.ua/d/uk/obyavlenie/avtonstruktor-privatn-uroki-avtomat-IDSef1A.html:801316494:0630211190
https://www.olx.ua/d/uk/obyavlenie/nstruktor-z-vodnnya-instruktor-s-vozhdeniya-avtoinstruktor-nstruktor-IDT4EOh.html:813808669:+380507202849
https://www.olx.ua/d/uk/obyavlenie/nstruktor-z-vodnnya-avtonstruktor-uroki-vodnnya-avtomat-mehanka-IDRFMAB.html:793104037:0960303603
https://www.olx.ua/d/uk/obyavlenie/avtonstruktor-kiv-IDSp5wR.html:803901539:+380634144366
https://www.olx.ua/d/uk/obyavlenie/avtoinstruktor-uroki-vozhdeniya-IDUBO5Y.html:836485522:+380505860093
https://www.olx.ua/d/uk/obyavlenie/avtoinstruktor-kiev-chastnye-uroki-vozhdeniya-bystroe-obuchenie-IDw0Mx4.html:458252978:0978072898
https://www.olx.ua/d/uk/obyavlenie/privatn-uroki-vodnnya-avtonstruktor-vs-rayoni-kiva-IDUrvWY.html:834036274:0939199515
https://www.olx.ua/d/uk/obyavlenie/avtoinstruktor-obuchayu-vozhdeniyu-IDRcrJU.html:786112378:0675045684
https://www.olx.ua/d/uk/obyavlenie/avtonstruktor-uroki-vodnnya-akpp-IDqfm46.html:387844478:0935367890
https://www.olx.ua/d/uk/obyavlenie/avtonstruktor-privatniy-nstruktor-z-vodnnya-avtoshkola-IDTq3ns.html:818907994:+380635335373
https://www.olx.ua/d/uk/obyavlenie/avtoinstruktor-instruktor-po-vozhdeniyu-us-rayoni-kiva-IDSuZnW.html:805307951:0939199515
https://www.olx.ua/d/uk/obyavlenie/praktika-vozhdeniya-avtoinstruktor-IDHfpue.html:639055342:0979460142
https://www.olx.ua/d/uk/obyavlenie/privatniy-nstruktor-uroki-vodnnya-avtonstruktor-avtoshkola-IDTpozO.html:818751156:+380635335373
https://www.olx.ua/d/uk/obyavlenie/nstruktor-z-vodnnya-avtonstruktor-IDOG5jq.html:748847000:0663623687
https://www.olx.ua/d/uk/obyavlenie/uroki-vozhdeniya-avtoinstruktor-kursy-pravyy-bereg-IDPAQP5.html:762375999:0679979986
https://www.olx.ua/d/uk/obyavlenie/nstruktor-z-vodnnya-avtonstruktor-uroki-vodnnya-avtoinstruktor-IDSzvNv.html:806389702:0731008050
https://www.olx.ua/d/uk/obyavlenie/nstruktor-z-vodnnya-avtonstruktor-IDQ0vOp.html:768495605:0933390231
https://www.olx.ua/d/uk/obyavlenie/avtoinstruktor-obuchenie-vozhdeniyu-korobka-avtomat-IDFS92I.html:618734252:0963902350
https://www.olx.ua/d/uk/obyavlenie/avtoinstruktor-kiev-chastnye-uroki-vozhdeniya-avtomat-IDTaHXh.html:815250727:0639798314
https://www.olx.ua/d/uk/obyavlenie/uroki-vozhdeniya-mehanika-avtomat-instruktor-po-vozhdeniyu-avtoinstruktor-IDIQI0P.html:662721027:0679802233
https://www.olx.ua/d/uk/obyavlenie/instruktor-po-vozhdeniyu-mkppuroki-vozhdeniya-obuchenie-vozhdeniyu-IDQclUw.html:771313635:0636801630
https://www.olx.ua/d/uk/obyavlenie/instruktor-po-vozhdeniyu-avtoinstruktor-IDUzApK.html:835956276:+380974580592
https://www.olx.ua/d/uk/obyavlenie/uroki-vozhdeniya-mehanika-instruktor-po-vozhdeniyu-avtoinstruktor-dnepr-IDOQ9GG.html:751247098:0665785871
https://www.olx.ua/d/uk/obyavlenie/nstruktor-z-vodnnya-uroki-vodnnya-IDPORBX.html:765715621:0953884648
https://www.olx.ua/d/uk/obyavlenie/uroki-vozhdeniya-avtomat-mehanika-avtoinstruktor-IDRFNNn.html:793108673:+380954434371
https://www.olx.ua/d/uk/obyavlenie/nstruktor-z-vodnnya-vishneve-kiv-uroki-vozhdeniya-kiev-avtonstruktor-IDEMItu.html:602664148:0997402509
https://www.olx.ua/d/uk/obyavlenie/avtonstruktor-kursi-vodnnya-nstruktor-avtomat-IDLmC1O.html:699877192:0935312096
https://www.olx.ua/d/uk/obyavlenie/avtonstruktor-privatniy-nstruktor-zaporzhzhya-IDTTPfp.html:826003519:0990973114
https://www.olx.ua/d/uk/obyavlenie/instruktor-po-vozhdeniyu-uroki-vozhdeniya-avtoinstruktor-avtoshkola-IDQPUMt.html:780742469:0965698357
https://www.olx.ua/d/uk/obyavlenie/avtoinstruktor-chastnye-uroki-vozhdeniya-avtomobilya-instruktor-v-kieve-IDI2Ev9.html:650791193:067-908-44-54
https://www.olx.ua/d/uk/obyavlenie/avtonstruktor-uroki-vodnnya-privatn-uroki-kursi-vodv-IDRZC5S.html:797830252:+380981812002
https://www.olx.ua/d/uk/obyavlenie/avtoinstruktor-chastnye-uroki-vozhdeniya-harkov-IDQKfkS.html:779391514:0501026118
https://www.olx.ua/d/uk/obyavlenie/avtoinstruktor-uroki-vozhdeniya-IDTAm4p.html:821363129:0995422584
https://www.olx.ua/d/uk/obyavlenie/privatn-uroki-vodnnya-avtonstruktor-sertifkovaniy-avtoshkola-kiv-IDUaDiv.html:830009160:0979131447
https://www.olx.ua/d/uk/obyavlenie/nstruktor-z-vodnnya-avtonstruktor-IDPvgqh.html:761282765:0987643797
https://www.olx.ua/d/uk/obyavlenie/avtoinstruktor-uroki-vozhdeniya-instruktor-vozhdenie-IDTaRfg.html:815286438:0933399298
https://www.olx.ua/d/uk/obyavlenie/instruktor-po-vozhdeniyu-na-akpp-IDHfoKG.html:639052518:0976881014
https://www.olx.ua/d/uk/obyavlenie/instruktor-po-vozhdeniyu-avtoinstruktor-harkov-IDQnutp.html:773968159:+380501026118
https://www.olx.ua/d/uk/obyavlenie/avtoinstruktor-kiev-obolon-minskiy-vinogradar-vyshgorod-i-dr-IDOTJq9.html:752099441:0674047174
https://www.olx.ua/d/uk/obyavlenie/instruktor-po-vozhdeniyu-avtomobilya-nstruktor-z-vodnnya-avtomat-IDCE0D0.html:571036306:0972174346
https://www.olx.ua/d/uk/obyavlenie/avtonstruktor-poltava-IDUgbSj.html:831333715:0677192273
https://www.olx.ua/d/uk/obyavlenie/avtonstruktor-avtonastavnik-IDTgWKd.html:816733701:0734151632
https://www.olx.ua/d/uk/obyavlenie/instruktor-po-vozhdeniyu-v-kieve-na-avtomate-avtoinstruktor-IDNizxx.html:728466987:0501601305
https://www.olx.ua/d/uk/obyavlenie/uroki-vodnnya-avtoshkola-taurus-avtonstruktor-z-vodnnya-IDSVltY.html:811827750:0931801177
https://www.olx.ua/d/uk/obyavlenie/avtonstruktor-uroki-vodnnya-IDKAfda.html:688349740:0938134062
https://www.olx.ua/d/uk/obyavlenie/nstruktor-z-vodnnya-avtonstruktor-IDKBA9C.html:688668572:0678602181
https://www.olx.ua/d/uk/obyavlenie/instruktor-po-obucheniyu-vozhdeniyu-avtoinstruktor-individ-obuchenie-IDJ4Ahs.html:666027898:+380995046281
https://www.olx.ua/d/uk/obyavlenie/instruktor-po-vozhdeniyu-IDTa737.html:815108861:0671564509
https://www.olx.ua/d/uk/obyavlenie/privatniy-nstruktor-z-vodnnya-avtonstruktor-IDTkY1P.html:817695793:+380635335373
https://www.olx.ua/d/uk/obyavlenie/avtoinstruktor-IDUjLy4.html:832185828:0972303218
https://www.olx.ua/d/uk/obyavlenie/avtoinstruktor-avto-moto-kursy-IDdFoeE.html:201956980:0678601765
https://www.olx.ua/d/uk/obyavlenie/avtonstruktor-u-lvov-nstruktor-z-vodnnya-privatn-uroki-vodnnya-IDMbVwv.html:712110642:0974511633
https://www.olx.ua/d/uk/obyavlenie/uroki-vodnnya-avtoshkola-taurus-avtomat-mehanka-avtonstruktor-IDRr4yi.html:789598166:0674392847
https://www.olx.ua/d/uk/obyavlenie/nstruktor-z-vodnnya-avtonstruktor-uroki-z-vodnnya-gostomel-bucha-ID8v2ZH.html:125848697:+380983492530
https://www.olx.ua/d/uk/obyavlenie/avto-nstruktor-praktichn-zanyattya-IDTEUEb.html:822449355:0666607210
https://www.olx.ua/d/uk/obyavlenie/uroki-vodnnya-avtonstruktor-IDRyhXr.html:791317993:063433-47-03
https://www.olx.ua/d/uk/obyavlenie/avtonstruktor-nstruktor-z-vodnnya-privatn-uroki-z-vodnnya-IDSPWCw.html:810298367:0971094000
https://www.olx.ua/d/uk/obyavlenie/instruktor-po-vozhdeniyu-kiev-vishnevoe-boyarka-kryukovschina-gatne-borsch-IDJod5F.html:670705315:0675044608
https://www.olx.ua/d/uk/obyavlenie/chastnyy-instruktor-avtoinstruktor-avtoshkola-IDTpnFQ.html:818747686:+380635335373
https://www.olx.ua/d/uk/obyavlenie/avtoinstruktor-obuchenie-vozhdeniyu-instruktor-vozhdenie-IDPSt8w.html:766574851:0933399298
https://www.olx.ua/d/uk/obyavlenie/avtonstruktor-vodnnya-vozhdenie-kursi-vodnnya-avtomat-keruvannya-IDUz61V.html:835839480:0639936340
https://www.olx.ua/d/uk/obyavlenie/avto-nstruktor-IDT09UH.html:812736591:0956683302
https://www.olx.ua/d/uk/obyavlenie/vodnnya-nstruktor-avtonstuktor-lvv-uroki-vodnnya-u-lvov-IDGAjhK.html:629260056:0676707999
https://www.olx.ua/d/uk/obyavlenie/instruktor-po-vozhdeniyu-uroki-vozhdeniya-avtomat-mehanika-IDRFESN.html:793074413:0954434371
https://www.olx.ua/d/uk/obyavlenie/avtoinstruktor-mkpp-IDUzW8m.html:836035922:0675172812
https://www.olx.ua/d/uk/obyavlenie/nstruktor-z-vodnnya-avtonstruktor-uroki-vodnnya-IDSX8uh.html:812016125:+380931829066
https://www.olx.ua/d/uk/obyavlenie/uroki-z-vodnnya-privatniy-avtonstruktor-pdgotovka-do-spitu-IDUg3ll.html:831300919:0930805854
https://www.olx.ua/d/uk/obyavlenie/uroki-vozhdeniya-instruktor-po-vozhdeniyu-avtoinstruktor-na-vashem-avto-IDSbsFw.html:800653957:098-220-22-02
https://www.olx.ua/d/uk/obyavlenie/instruktor-po-vozhdeniyu-avtoinstruktor-uroki-vozh-IDTpK09.html:818833513:0976869653
https://www.olx.ua/d/uk/obyavlenie/avtonstruktor-uroki-vodnnya-IDSH3RE.html:808185106:0958052292
https://www.olx.ua/d/uk/obyavlenie/avtonstruktor-vd-300-grn-godinu-lvv-mehanka-avtomat-IDOu2KT.html:745977235:0632151306
https://www.olx.ua/d/uk/obyavlenie/avtonstruktor-privatn-uroki-vodnnya-avtoinstruktor-nstruktor-IDJB1eI.html:673758012:0992546548
https://www.olx.ua/d/uk/obyavlenie/instruktor-po-vozhdeniyu-avtoinstruktor-uroki-vozhdeniya-dlya-zhenschin-IDIUqVJ.html:663608737:0687225740
https://www.olx.ua/d/uk/obyavlenie/avtonstruktor-navchannya-na-avtomoblyah-uchnv-v-kiv-ta-oblast-IDUiiH3.html:831836581:0952772904
https://www.olx.ua/d/uk/obyavlenie/vozhdeniya-vosstanovlenie-navykov-avtoinstruktor-IDKnhyq.html:685260482:0678605735
https://www.olx.ua/d/uk/obyavlenie/avtoinstruktor-instruktor-po-vozhdeniyu-avtoshkola-obuchenie-vozhdeniyu-IDQ9gdj.html:770576753:0933399298
https://www.olx.ua/d/uk/obyavlenie/instruktor-po-vozhdeniyu-harkov-vozhdenie-avtoinstruktor-ID5olrw.html:79683981:0958962858
https://www.olx.ua/d/uk/obyavlenie/avtoinstruktor-instruktor-po-vozhdeniyu-avtoshkola-chastnye-uroki-vozhdeniya-IDOMP0i.html:750452606:+380635335373
https://www.olx.ua/d/uk/obyavlenie/uroki-vodnnya-avtonstruktor-nstruktor-z-vodnnya-avtomoblya-IDS4Zba.html:799110632:0962388646
https://www.olx.ua/d/uk/obyavlenie/avtonstruktor-privatn-uroki-vodnnya-avtomoblya-IDOC1cL.html:747877899:+380639688338
https://www.olx.ua/d/uk/obyavlenie/obuchenie-vozhdeniyu-avtoinstruktor-mehanika-uroki-vozhdeniya-IDRV2c9.html:796977273:0503305484
https://www.olx.ua/d/uk/obyavlenie/uroki-vodinnya-avtoinstruktor-uroki-vozhdeniya-avtoistruktor-IDSGDIE.html:808084604:0968867373
https://www.olx.ua/d/uk/obyavlenie/uroki-vozhdeniya-chastnyy-avtoinstruktor-vosstanovleniya-navykov-vozhdeniya-IDQWPKe.html:782153078:+380675379785
https://www.olx.ua/d/uk/obyavlenie/instruktor-po-vozhdeniyu-chastniy-avtoinstruktor-avtoshkola-IDUDUWt.html:836988435:+380635335373
https://www.olx.ua/d/uk/obyavlenie/chastnye-uroki-vozhdeniya-avtoinstruktor-levyy-bereg-troeschina-darnitsa-IDxYbn6.html:501962484:0978072898
https://www.olx.ua/d/uk/obyavlenie/uroki-vodnnya-avtonstruktor-vodnnya-navchannya-IDTyKIt.html:820981213:0731008050
https://www.olx.ua/d/uk/obyavlenie/avtoinstruktor-uroki-vozhdeniya-dlya-zhenschin-IDTauPC.html:815200280:0978072898
https://www.olx.ua/d/uk/obyavlenie/nstruktor-z-vodnnya-avtonstruktor-IDSVxVb.html:811875627:+380683586703
https://www.olx.ua/d/uk/obyavlenie/avtoinstruktor-po-vozhdeniyu-uroki-vozhdeniya-instruktor-avtoshkola-IDTFn6e.html:822558726:067-272-6789
https://www.olx.ua/d/uk/obyavlenie/avtonstruktor-ndivdualn-navchannya-vodnnyu-IDUcLll.html:830516743:0963495731
https://www.olx.ua/d/uk/obyavlenie/privatn-uroki-z-vodnnya-avtoinstruktor-obolon-podol-svyatosh-IDQU5e2.html:781735930:0937752292
https://www.olx.ua/d/uk/obyavlenie/avtonstruktor-nstruktor-z-vodnnya-uroki-vodnnya-vodnnya-avtomat-IDUCDP8.html:836684366:0977088081
https://www.olx.ua/d/uk/obyavlenie/vozhdenie-avtomobilya-avtoinstruktor-IDQKf4Z.html:779390529:0679121715
https://www.olx.ua/d/uk/obyavlenie/ndivdualn-uroki-po-vodnnyu-avtonstruktor-IDJ9LJU.html:667263586:+380686887070
https://www.olx.ua/d/uk/obyavlenie/avtonstruktor-na-vashomu-avto-IDTo4Tb.html:818437149:0939788328
https://www.olx.ua/d/uk/obyavlenie/avtoinstruktor-uroki-vozhdeniya-kat-v-IDRkXQn.html:788142411:+380634144366
https://www.olx.ua/d/uk/obyavlenie/avtonstruktor-uroki-vodnnya-IDTfIBC.html:816444868:0509937530
https://www.olx.ua/d/uk/obyavlenie/privatniy-avtonstruktor-nstruktor-z-vodnnya-avtoinstruktor-if-IDQQCmU.html:780910020:0673065024
https://www.olx.ua/d/uk/obyavlenie/uroki-vozhdeniya-mehanika-450grn-instruktor-po-vozhdeniyu-avtoinstruktor-IDsLgwu.html:425002280:0665785871
https://www.olx.ua/d/uk/obyavlenie/nstruktor-z-vodnnya-privatn-uroki-avtonstruktor-IDU4BP0.html:828573518:+380963095248
https://www.olx.ua/d/uk/obyavlenie/instruktor-avtoinstruktor-obuchenie-vozhdenie-chastnye-uroki-IDRBqID.html:792066655:0933399298
https://www.olx.ua/d/uk/obyavlenie/avtonstruktor-privatniy-nstruktor-z-vodnnya-nstroktor-z-vodnnya-IDS8hIE.html:799896884:+380635335373
https://www.olx.ua/d/uk/obyavlenie/avtoshkola-avtoinstruktor-avtokursy-na-mehanike-IDPmq3s.html:758936510:+380932023337
https://www.olx.ua/d/uk/obyavlenie/avtoinstruktor-kiev-vishnevoe-IDR6Dj0.html:784726870:0675044608
https://www.olx.ua/d/uk/obyavlenie/kursi-vodnnya-mehanka-avtomat-avtoshkola-avtonstruktor-IDRr1Yj.html:789588247:0674392847
https://www.olx.ua/d/uk/obyavlenie/obhoditelnyy-vnimatelnyy-avtoinstruktor-kotoryy-nauchit-ezde-v-dnepre-IDL8RMH.html:696601167:0509088134
https://www.olx.ua/d/uk/obyavlenie/avtonstruktor-uroki-vodnnya-mehanka-ta-avtomat-IDLClnh.html:703626423:0678605735
https://www.olx.ua/d/uk/obyavlenie/avtoinstruktor-v-kieve-obolon-minskiy-vinogradar-vyshgorod-i-dr-IDQ6HMH.html:769967751:0674047174
https://www.olx.ua/d/uk/obyavlenie/nstruktor-z-vodnnya-avtonstruktor-navchannya-vodnnya-IDSWrq8.html:811612248:0933399298
https://www.olx.ua/d/uk/obyavlenie/obuchayu-vozhdeniyu-na-legkovom-avtomobile-IDR6krN.html:784654379:0930617721
https://www.olx.ua/d/uk/obyavlenie/instruktor-avtoinstruktor-uroki-vozhdeniya-avtoshkola-IDUrlAK.html:833992674:0970010131
https://www.olx.ua/d/uk/obyavlenie/peregon-avto-po-ukran-uslugi-trezvogo-lichnogo-voditelya-perevozki-IDTqyUk.html:819029196:0937078080
https://www.olx.ua/d/uk/obyavlenie/uroki-vodnnya-avtonstruktor-IDSYslc.html:812330770:0637909964
https://www.olx.ua/d/uk/obyavlenie/uroki-vozhdeniya-avtoinstruktor-IDRqMuH.html:789528751:0954434371
https://www.olx.ua/d/uk/obyavlenie/avtonstruktor-z-vodnnya-nstruktor-IDS3P6L.html:798833591:0996295535
https://www.olx.ua/d/uk/obyavlenie/nstruktor-z-vodnnya-avtonstruktor-privatn-uroki-vodnnyamehanka-IDSzmqy.html:806349838:0937485238
https://www.olx.ua/d/uk/obyavlenie/avtoinstruktor-akpp-400-grn-chas-IDMO6Mt.html:721206597:0952254930
https://www.olx.ua/d/uk/obyavlenie/nstruktor-z-vodnnya-privatn-uroki-avtonstruktor-IDIlPAi.html:655361966:0963095248
https://www.olx.ua/d/uk/obyavlenie/uroki-vozhdeniya-avtoinstruktor-v-vinnitse-IDOoC3a.html:744682940:0964253642';

$exp = explode('
',$data);

foreach ($exp as $value) {
	$exp2 = explode(':',$value);
	$id = $exp2[2];
	$phone = str_replace(' ','',str_replace('-','',str_replace('+38','',$exp2[3])));


	$cleanedNumber = preg_replace("/[^0-9]/", "", $phone);

	// Форматирование номера телефона
	$phone_b = sprintf("+38 (%s) %s-%s-%s",
	    substr($cleanedNumber, 0, 3),
	    substr($cleanedNumber, 3, 3),
	    substr($cleanedNumber, 6, 2),
	    substr($cleanedNumber, 8, 2)
	);


	$modx->db->query('UPDATE `modx_a_instructors` SET phone = "'.$modx->db->escape($phone_b).'" WHERE source_id = "'.$modx->db->escape($id).'" ');
}









die;
*/

/*
    function getpage($url) {
	$referer = 'https://www.olx.ua/';
	$origin = 'https://www.olx.ua';
      $ch     = curl_init();
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_POST, 1);
      $headers = array(
	    'Referer: ' . $referer,
	    'Origin: ' . $origin
	);
$data = array(
    'path' => '/exchange'
);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
      curl_setopt($ch, CURLOPT_HTTPHEADER, $headers); 
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // возвратить то что вернул сервер
      curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); // следовать за редиректами
      curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);// таймаут4
      curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36");
      $result = curl_exec($ch);
      curl_close ($ch);
      return $result;
    }

$page = getpage('https://friction.olxgroup.com');

var_dump($page);die;

Friction-Token:

https://www.olx.ua/api/v1/offers/740575525/limited-phones/
*/

die;


$q = $modx->db->query('SELECT *
FROM `modx_a_parse_a`
WHERE  parsed = "0" ');
while($r = $modx->db->getRow($q)){
	$instructor_url = $shop->generateSlug($r['name'].'-'.rand(10000,99999));
    $modx->db->query('INSERT INTO `modx_a_instructors`
    	SET 
    	status = "1",
    	duration = "60",
        registration_date = "'.$modx->db->escape(date('Y-m-d H:i:s')).'",
    	instructor_hash = "'.$modx->db->escape(uniqid()).'",
        instructor_url = "'.$modx->db->escape($instructor_url).'",
    	city = "'.$modx->db->escape($r['city']).'",
    	district = "'.$modx->db->escape($r['district']).'",
    	photo = "'.$modx->db->escape($r['photos']).'",
    	description = "'.$modx->db->escape($r['description']).'",
    	price = "'.$modx->db->escape($r['price']).'",
    	fullname = "'.$modx->db->escape($r['name']).'",
    	title = "'.$modx->db->escape($r['title']).'",
    	transmission = "'.$modx->db->escape($r['transmission']).'",
    	type = "'.$modx->db->escape($r['type']).'",
    	source_id = "'.$modx->db->escape($r['olxid']).'",
    	source_url = "'.$modx->db->escape($r['url']).'",
    	source = "1"
    ');
    $modx->db->query('INSERT INTO `modx_a_virtual` SET 
      type = "1",
      idv = "'.$modx->db->escape($id).'",
      url = "'.$modx->db->escape($instructor_url).'"
      ');


    $modx->db->query('UPDATE `modx_a_parse_a`SET
    	parsed = "1"
    	WHERE id = "'.$modx->db->escape($r['id']).'" LIMIT 1');

}



echo 'ok';die;










/* parser цін
$q = $modx->db->query('SELECT *
FROM `modx_a_parse_a`
WHERE `description` LIKE "%гр.%" AND parsed = "0" ');
while($r = $modx->db->getRow($q)){


$reg = '/(\d+)\s*гр/';


	if (preg_match($reg, $r['description'], $match)) {
	    $price = $match[1];
	    echo "Извлеченная стоимость:" .$price.'</br>';

	    $q = $modx->db->query('UPDATE  `modx_a_parse_a`
	    	SET price = "'.$modx->db->escape($price).'",
	    	parsed = "1"
	    	WHERE id = "'.$modx->db->escape($r['id']).'" LIMIT 1');

	} else {
	    var_dump($r['id'],$r['description']);die;
	}

}
die;
*/

/*
OLX парсер об'яв Забрати місто район

$q = $modx->db->query('SELECT * FROM `modx_a_parse_a` WHERE parsed = "0"  LIMIT 100');
while($r = $modx->db->getRow($q)){
	
	
	$url = 'https://www.olx.ua/api/v1/targeting/data/?page=ad&params%5Bad_id%5D='.$r['olxid'] .'&dfp_user_id=0&advertising_test_token=';
	$page = $shop->get_page($url);

	$ar = json_decode($page,true);

	$city = $ar['data']['targeting']['city'];
	$district = $ar['data']['targeting']['district'];

	$modx->db->query('UPDATE `modx_a_parse_a`
     SET 
     city = "'.$modx->db->escape($city).'",
     district = "'.$modx->db->escape($district).'",
     parsed = "1"
	 WHERE id = "'.$modx->db->escape($r['id']).'"
	 ');
}
die;
*/




/*
OLX парсер об'яв Забрати фото

$q = $modx->db->query('SELECT * FROM `modx_a_parse_a` WHERE parsed = "0"  LIMIT 100');
while($r = $modx->db->getRow($q)){
	unset($photos);
	$photos = array();
	$imgs = explode(',',$r['imgs']);
	foreach($imgs as $img){
		$name = preg_replace('/\D+/', '', microtime()).'.jpg';
		$nn = 'assets/files/instructors/olx/'.$name;
		$nb = '/'.$nn;
		$photos[] = $nb;
		copy($img, MODX_BASE_PATH.$nn);

	}
	$modx->db->query('UPDATE `modx_a_parse_a`
     SET 
     photos = "'.$modx->db->escape(implode(',', $photos)).'",
     parsed = "1"
	 WHERE id = "'.$modx->db->escape($r['id']).'"
	 ');
}
die;

*/
/*
OLX парсер об'яв Забрати дані
$q = $modx->db->query('SELECT * FROM `modx_a_parse_a` WHERE parsed = "0" LIMIT 30');
while($r = $modx->db->getRow($q)){
	$url = $r['url'];

	$page = $shop->get_page($url);
    $html = phpQuery::newDocument($page);
    $imgs = array();
    foreach ($html->find('.swiper-zoom-container img') as $img) {
    	$im = pq($img)->attr('src');
    	$imgs[] = $im;
    }
    $id = str_replace('ID: <!-- -->','',$html->find('.css-12hdxwj')->html());
    $title = $html->find('.css-1juynto')->html();
    $date = $html->find('.css-19yf5ek')->html();
    $name = $html->find('.css-18icqaw .css-1lcz6o7')->html();

    $description = $html->find('.css-1t507yq')->html();

    if(count($imgs) > 0){
    	$im_im = implode(',', $imgs);
	}
    $type = '';
    $transmission = '';
    $owner = '';
    foreach ($html->find('.css-1r0si1e .css-b5m1rv') as $tag) {
    	$tt = strip_tags(pq($tag)->html());
		    	
		$ss = "Тип КПП:";
		if (strpos($tt, $ss) !== false) {
		    //Тип КПП:
			$transmission = trim(str_replace($ss,'',$tt));
		} else {
			$ss2 = "Власник авто:";
			if (strpos($tt, $ss2) !== false) {
			    //Власник авто: 
				$owner = trim(str_replace($ss2,'',$tt));
			} else {
				$ss3 = "Категорія:";
				if (strpos($tt, $ss3) !== false) {
				    //Власник авто: 
					$type = trim(str_replace($ss3,'',$tt));
				} else {

				}
			}
		}

    }



	$modx->db->query('UPDATE `modx_a_parse_a`
     SET 
     transmission = "'.$modx->db->escape($transmission).'",
     type = "'.$modx->db->escape($type).'",
     owner = "'.$modx->db->escape($owner).'",
     title = "'.$modx->db->escape($title).'",
     name = "'.$modx->db->escape($name).'",
     date = "'.$modx->db->escape($date).'",
     olxid = "'.$modx->db->escape($id).'",
     description = "'.$modx->db->escape($description).'",
     imgs = "'.$modx->db->escape($im_im).'",
     parsed = "1"
	 WHERE id = "'.$modx->db->escape($r['id']).'"
	 ');
}


die;
*/

/*
OLX парсер об'яв Забрати посилання
$url = 'https://www.olx.ua/uk/uslugi/q-%D0%B0%D0%B2%D1%82%D0%BE%D0%B8%D0%BD%D1%81%D1%82%D1%80%D1%83%D0%BA%D1%82%D0%BE%D1%80/';
for($i = 1; $i <= 14; $i++){
	if($i == 1){
		$url_p = $url;
	}else{
		$url_p = $url.'?page='.$i;
	}
	$page = $shop->get_page($url_p);
    $html = phpQuery::newDocument($page);
    foreach ($html->find('.css-oukcj3 .css-1sw7q4x') as $adv) {
       	$a = pq($adv)->find('a');
       	$href = 'https://www.olx.ua'.pq($a)->attr('href');
       	$modx->db->query('INSERT IGNORE INTO `modx_a_parse_a` SET url = "'.$modx->db->escape($href).'" ');
    }	
}
echo "ok";
die;
*/

/*
for($i = 1; $i <= 34; $i++){
	$pdr = 'https://pdr.infotech.gov.ua/theory/rules/'.$i;

	$page = $shop->get_page($pdr);


      $html = phpQuery::newDocument($page);
      
      $title = $html->find('.page-title h1')->html();

      $modx->db->query('INSERT INTO `new_pdr_chapter` SET `chapter` = "'.$modx->db->escape($i).'", `name` = "'.$modx->db->escape($title).'" ');

      foreach ($html->find('.MuiCardContent-root > div .MarkdownPage_contentWrap__jg5mr') as $chapter) {
       	$text = pq($chapter)->html();
       	$attr = pq($chapter)->attr('id');
       	$modx->db->query('INSERT INTO `new_pdr_chapter_item` SET `chapter` = "'.$modx->db->escape($i).'", `number` = "'.$modx->db->escape($attr).'", `description` = "'.$modx->db->escape($text).'" ');

       }
      


}
*/
