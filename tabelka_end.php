<?php
date_default_timezone_set('Europe/Warsaw');
require_once('php/konekt.php');

// tu odbieramy dane post i robimy z nimi co chcemy, po czym zwracamy odpoiwedź i kończymy wykonanie skryptu
// najlepiej to umieścić w innym pliku, który będzie odpowiadał tylko za obługę wywołań ajaxem
if (count($_POST)) {

// Tu jeszcze wypadaałoby zabezpieczyć te dane wysyłane postem przez sql injection np przy pomocy mysqli::real_escape_string() lub $mysqli->prepare()
$insert = "INSERT IGNORE INTO zamowienia (kto, co, marza, cena, uwagi, przyjechalo, fv_zakup_typ, fv_par, zakonczono)
   VALUES ( '" . $_POST['kto'] . "', '" . $_POST['co'] . "', '" . $_POST['marza'] . "', '" . $_POST['cena'] . "', '" . $_POST['uwagi'] . "', 
    '" . $_POST['przyjechalo'] . "', '" . $_POST['fv_zakup_typ'] . "', '" . $_POST['fv_par'] . "', '" . $_POST['zakonczono'] . "')";
$result = mysqli_query($link, $insert);
/////////////////////////////////////   
 
  echo json_encode([
    'status' => $result ? 'OK' : 'ERROR',
    'msg' =>  $result ? 'Pomyślnie zapisano dane' :  mysqli_error($link),
    'savedData' => $_POST,
    'insertedId' => mysqli_insert_id($link)
  ]);
  exit();
 
}

?>

<html>
<head>
  <meta charset="utf-8">
  <title>System zamawiarki BOOSTNET</title>

  <!-- jQuery -->
  <script src="js/jquery-latest.min.js"></script>

  <!-- Demo wyglądu -->
  <link rel="stylesheet" href="css/jq.css">
  <link href="css/prettify.css" rel="stylesheet">
  <script src="js/prettify.js"></script>
  <script src="js/docs.js"></script>

  <!-- Wymagane przez jqery do sortowania-->
  <link rel="stylesheet" href="css/theme.ice.min.css">
  <script src="js/jquery.tablesorter.js"></script>

  <script id="js">
    $(function() {
      // wdzwanianie sie do skryptu
      $("table").tablesorter({
        theme: 'ice',

        sortReset: true,

        sortRestart: true,

        sortInitialOrder: 'desc',

        headers: {

          1: {
            sortInitialOrder: 'asc'
          },
          2: {
            sortInitialOrder: 'asc'
          },
          3: {
            sortInitialOrder: 'asc'
          },
          4: {
            sortInitialOrder: 'asc'
          },
          5: {
            sortInitialOrder: 'asc'
          },
          6: {
            sortInitialOrder: 'asc'
          },
          7: {
            sortInitialOrder: 'asc'
          },
          8: {
            sortInitialOrder: 'asc'
          },
          9: {
            sortInitialOrder: 'asc'
          }
        }

      });

    });
  </script>

  <!-- zaczyna sie head dla popupa -->
  <link rel="stylesheet" href="css/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <style>
    label,
    input {
      display: block;
    }

    input.text {
      margin-bottom: 12px;
      width: 95%;
      padding: .4em;
    }

    fieldset {
      padding: 0;
      border: 0;
      margin-top: 25px;
    }

    h1 {
      font-size: 1.2em;
      margin: .6em 0;
    }

    div#users-contain {
      width: 350px;
      margin: 20px 0;
    }

    div#users-contain table {
      margin: 1em 0;
      border-collapse: collapse;
      width: 100%;
    }

    div#users-contain table td,
    div#users-contain table th {
      border: 1px solid #eee;
      padding: .6em 10px;
      text-align: left;
    }

    .ui-dialog .ui-state-error {
      padding: .3em;
    }

    .validateTips {
      border: 1px solid transparent;
      padding: 0.3em;
    }
  </style>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script>
    $(function() {
      var dialog, form,

        // From http://www.whatwg.org/specs/web-apps/current-work/multipage/states-of-the-type-attribute.html#e-mail-state-%28type=email%29
        emailRegex = /^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/,
        kto = $("#kto"),
        co = $("#co"),
        marza = $("#marza"),
        ustalona = $("#ustalona"),
        uwagi = $("#uwagi"),
        przyjechalo = $("#przyjechalo"),
        zakup = $("#zakup"),
        fv = $("#fv"),
        zakonczono = $("#zakonczono"),
        allFields = $([]).add(kto).add(co).add(marza).add(ustalona).add(uwagi).add(przyjechalo).add(zakup).add(fv).add(zakonczono),
        tips = $(".validateTips");

      function updateTips(t) {
        tips
          .text(t)
          .addClass("ui-state-highlight");
        setTimeout(function() {
          tips.removeClass("ui-state-highlight", 1500);
        }, 500);
      }

      function checkLength(o, n, min, max) {
        if (o.val().length > max || o.val().length < min) {
          o.addClass("ui-state-error");
          updateTips("Length of " + n + " must be between " +
            min + " and " + max + ".");
          return false;
        } else {
          return true;
        }
      }

      function checkRegexp(o, regexp, n) {
        if (!(regexp.test(o.val()))) {
          o.addClass("ui-state-error");
          updateTips(n);
          return false;
        } else {
          return true;
        }
      }

      function dodajZamowienie() {
        var valid = true;
        allFields.removeClass("ui-state-error");

      
        console.log('valid', valid);
        if (valid) {
          // WJ - tu dodałem
          form2.submit();
          dialog.dialog("close");
        }
        return valid;
      }

      dialog = $("#dialog-form").dialog({
        autoOpen: false,
        height: 500,
        width: 500,
        modal: true,
        buttons: {
          "Dodaj zamówienie": dodajZamowienie,
          Zrezygnuj: function() {
            dialog.dialog("close");
          }
        },
        close: function() {
          $("#dialog-form form")?.[0]?.reset(); // WJ - nie wiem czy to potzrzebne ale zmieniłem bo poprzednia wersja powodowała błąd
          allFields.removeClass("ui-state-error");
        }
      });

      //poczatek zmiany czesia

      const form2 = dialog.find("form");
      form2.on("submit", function(event) {
        console.log('submit')
        event.preventDefault();

        // zmienn form musi być obiektem jQuery - jeśli ta zmienna to coś innego, to możesz pobrac form jak poniżej
        // var form	= $(this).closest('form');
        // WJ -form -> form2
        var data = form2.serialize();
        var action = form2.attr('action');

        $.ajax({
          type: "POST",
          contentType: "application/x-www-form-urlencoded; charset=UTF-8",
          url: action,
          data: data,
          success: function(dane) {
            var response = {}; // spodziewamy się odpowiedzi w postaci json, np takiej: {status:"OK", msg: "Zapisan dane"}
            try {
              response = jQuery.parseJSON(dane);
            } catch (err) {
              response = {
                status: "ERROR",
                msg: "Niezrozumiała odpowiedź od serwera."
              }
              console.log('parseJSON error: ' + err.message);
            }

            if (response?.msg) alert(response.msg);
            else alert("Nieznana odpowiedź serwera");
            
            if (response?.status == 'OK' && response.savedData) {
              addRowToTable(response.insertedId, response.savedData);
            }
          },
          error: function(jqXHR, exception) {
            // to przykłąd parsowania błędów ajaxa - warto wrzucić do osobnej funkcji
            var odp = '';
            if (jqXHR.status === 0) {
              odp = 'Not connect. Verify Network.';
            } else if (jqXHR.status == 404) {
              odp = 'Requested page not found. [404]';
            } else if (jqXHR.status == 500) {
              odp = 'Internal Server Error [500].';
            } else if (exception === 'parsererror') {
              odp = 'Requested JSON parse failed.';
            } else if (exception === 'timeout') {
              odp = 'Time out error.';
            } else if (exception === 'abort') {
              odp = 'Ajax request aborted.';
            } else {
              odp = 'Uncaught Error.\n' + jqXHR.responseText;
            }
            alert(odp);
          }
        });

      });

      // WJ
      function addRowToTable(insertedId, formData) {
          console.log('sss', $("#demo tbody tr:last-child td.column-lp"));
            $("#demo tbody").append("<tr>" +
            "<td class='column-lp'>" + insertedId + "</td>" +
            "<td>" + formData.kto + "</td>" +
            "<td>" + formData.co + "</td>" +
            "<td>" + formData.marza + "</td>" +
            "<td>" + formData.ustalona + "</td>" +
            "<td>" + formData.uwagi + "</td>" +
            "<td>" + formData.przyjechalo + "</td>" +
            "<td>" + formData.zakup + "</td>" +
            "<td>" + formData.fv + "</td>" +
            "<td>" + formData.zakonczono + "</td>" +
            "</tr>");
           }

      //koniec zmian czesia

      //    form = dialog.find( "form" ).on( "submit", function( event ) {
      //      event.preventDefault();
      //      dodajZamowienie();
      //    });

      $("#create-user").button().on("click", function() {
        dialog.dialog("open");
      });
    });
  </script>
  <!-- konczy sie head dla popupa -->

</head>

<body>

  <div id="main">

    <center>
      <h1>Zamawiarka BOOSTNET</h1><br>
    </center>
    <a href="index.php"><img src="img/wstecz.png"></a>&nbsp;<img src="img/dodaj.png" id="create-user">&nbsp;<a href="tabelka.php"><img src="img/aktywne.png"></a>&nbsp;<a href="tabelka.php"><img src="img/wszystkie.png"></a>&nbsp;<a href="raporty.php"><img src="img/raporty.png"></a><br>
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
        <tbody>


          <?php
          

          $zamowienia = mysqli_query($link, "SELECT id,kto,co,marza,cena,uwagi,przyjechalo,fv_zakup_typ,fv_par,zakonczono FROM zamowienia WHERE zakonczono='t' ");

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
                ");
          };

          ?>
        </tbody>
      </table>
    </div>
  </div>

  <!-- zaczyna sie body dla popupa -->
  <div id="dialog-form" title="Dodaj zamówienie">
    <p class="validateTips">Wszystkie pola są wymagane.</p>

    <form>
      <fieldset>
        <label for="kto">Kto</label>
        <input type="text" name="kto" id="kto" value="Sławek" class="text ui-widget-content ui-corner-all">
        <label for="co">Co</label>
        <input type="text" name="co" id="co" value="Grzesiek" class="text ui-widget-content ui-corner-all">
        <label for="marza">Marza</label>
        <input type="marza" name="marza" id="marza" value="10" class="text ui-widget-content ui-corner-all">
        <label for="ustalona">Cena ustalona(brutto)</label>
        <input type="ustalona" name="ustalona" id="ustalona" value="100" class="text ui-widget-content ui-corner-all">
        <label for="uwagi">Uwagi</label>
        <input type="uwagi" name="uwagi" id="uwagi" value="Uwagi do zamówienia" class="text ui-widget-content ui-corner-all">
        <label for="przyjechalo">Przyjechalo</label>
        <input type="przyjechalo" name="przyjechalo" id="przyjechalo" value="10" class="text ui-widget-content ui-corner-all">
        <label for="zakup">Zakup</label>
        <input type="zakup" name="zakup" id="zakup" value="mail/kuweta" class="text ui-widget-content ui-corner-all">
        <label for="fv">fv</label>
        <input type="fv" name="fv" id="fv" value="tak/nie" class="text ui-widget-content ui-corner-all">
        <label for="zakonczono">Zakonczono</label>
        <input type="zakonczono" name="zakonczono" id="zakonczono" value="tak/nie" class="text ui-widget-content ui-corner-all">


        <!-- Allow form submission with keyboard without duplicating the dialog button -->
        <input type="submit" tabindex="-1" style="position:absolute; top:-1000px">
      </fieldset>
    </form>
  </div>
  <!-- konczy sie body dla popupa -->
</body>

</html>