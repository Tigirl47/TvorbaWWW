<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/2000/REC-xhtml1-20000126/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="cs" lang="cs">

<head>
    <meta http-equiv="content-type" content="text/html; charset=windows-1250" />
    <title>
        <?php echo $titul_stranky; ?>
    </title>
</head>

<body>
    <!-- hlavicka.php -->
    <table border="0" cellspacing="0" cellpadding="4">
        <tr> <!-- HORNÍ ŘÁDEK -->
            <td rowspan="2" bgcolor="#999966"><img src="obrazky/inet.jpg" alt="pstruh" width="100" height="47" /></td>
            <td width="*" bgcolor="#999966">
                <font color="#FFFFFF" size="+2" face="Courier New, Courier, mono"><strong>TWS II.</strong></font>
            </td>
            <td width="10" rowspan="2" bgcolor="#999966">&nbsp;</td>
        </tr>
        <tr> <!-- ŘÁDEK NAVIGACE -->
            <td bgcolor="#CC9933">
                <table width="100%" border="0" cellspacing="2" cellpadding="2">
                    <tr>
                        <td width="20%" align="center" bgcolor="#FFCC66"><a href="index.php">Domů</a></td>
                        <td width="20%" align="center" bgcolor="#FFCC66"><a href="registruj.php">Registrace</a></td>
                        <td width="20%" align="center" bgcolor="#FFCC66">
                            <?php
                            if (isset($_COOKIE['id_uzivatele']) and (substr($_SERVER['PHP_SELF'], -10) != 'odhlasit.php')) {
                                echo '<a href="odhlasit.php">Odhlásit</a>';
                            } else {
                                echo '<a href="login.php">Přihlásit</a>';
                            }
                            ?>
                        </td>
                        <td width="20%" align="center" bgcolor="#FFCC66" nowrap="nowrap"><a href="zmena_hesla.php">Změna
                                hesla</a></td>
                        <td width="20%" align="center" bgcolor="#FFCC66" nowrap="nowrap"><a
                                href="zobraz_uzivatele.php">Zobrazení uživatelů</a></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr> <!-- ŘÁDEK OBSAHU -->
            <td bgcolor="#999966">&nbsp;</td>
            <td bgcolor="#FFFFFF"><!-- ZDE ZAČÍNÁ SPECIFICKÝ OBSAH STRÁNKY -->