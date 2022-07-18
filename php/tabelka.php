<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Test Tablesortera</title>

    <!-- jQuery -->
    <script src="js/jquery-latest.min.js"></script>

    <!-- Demo wyglądu -->
    <link rel="stylesheet" href="css/jq.css">
    <link href="css/prettify.css" rel="stylesheet">
    <script src="js/prettify.js"></script>
    <script src="js/docs.js"></script>

    <!-- Wymagane przez jqery do sortowania-->
    <link rel="stylesheet" href="css/theme.blue.css">
    <link rel="stylesheet" href="css/theme.ice.min.css">
    <script src="js/jquery.tablesorter.js"></script>

    <script id="js">
        $(function () {
            // wdzwanianie sie do skryptu
            $("table").tablesorter({
                theme: 'ice',

                sortReset: true,

                sortRestart: true,

                sortInitialOrder: 'desc',

                headers: {

                    3: { sortInitialOrder: 'asc' },
                    4: { sortInitialOrder: 'asc' },
                    5: { sortInitialOrder: 'asc' },
                    6: { sortInitialOrder: 'asc' },
                    7: { sortInitialOrder: 'asc' },
                    8: { sortInitialOrder: 'asc' },
                    9: { sortInitialOrder: 'asc' }
                }

            });

        });
    </script>
</head>

<body>

    <div id="main">

        <center>
            <h1>Zamawiarka</h1>
        </center>
        <div id="demo">
            <table class="tablesorter">
                <thead>
                    <tr>
                        <th>LP</th>
                        <th>Kto zamawia</th>
                        <th>Co zamawiane</th>
                        <th>Marża netto</th>
                        <th>Cena ustalona brutto</th>
                        <th>Uwagi</th>
                        <th>Przyjechalo</th>
                        <th>FV zakupu typ</th>
                        <th>FV czy Par</th>
                        <th>Zakończono</th>
                    </tr>
                </thead>
        
                
<?php 
date_default_timezone_set('Europe/Warsaw');
include ('php/konekt.php');

$zamowienia = mysqli_query($link,"SELECT id,kto,co,marza,cena,uwagi,przyjechalo,fv_zakup_typ,fv_par,zakonczono FROM zamowienia ");
    
    /* fetch object array */
    while ($zmienna = $zamowienia->fetch_row()) {
        $id = $zmienna[0];
        $kto = $zmienna[1];
        $co = $zmienna[2];
        $marza = $zmienna[3];
        $cena = $zmienna[4];
        $uwagi = $zmienna[5];
        $przyjechalo = $zmienna[6];
        $fv_zakup_typ = $zmienna[7];
        $fv_par = $zmienna[8];
        $zakonczono = $zmienna[9];

////////////////// poczatek generowania tabelki wraz ze wszstkim ///////////////////////
 
echo ("


                <tbody>
                    <tr>
                        <td>$id</td>
                        <td>$kto</td>
                        <td>$co</td>
                        <td>$marza</td>
                        <td>$cena</td>
                        <td>$uwagi</td>
                        <td>$przyjechalo</td>
                        <td>$fv_zakup_typ</td>
                        <td>$fv_par</td>
                        <td>$zakonczono</td>
                    </tr>
                    
                   

                </tbody>
                
");          

    };
    
?>           

</table>
        </div>




    </div>

</body>

</html>

