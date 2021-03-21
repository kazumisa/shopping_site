<?php
session_start();
require_once('./dbc_create_user.php');

// インスタンス化
$user = new User();

// ログインユーザの存在を確認
if(isset($_SESSION['login_user'])) {
  header('Location: ./index.php');
}

// 受け取った$_SESSION['err']を変数に格納
if(isset($_SESSION['err'])) {
  $err = $_SESSION['err'];

  unset($_SESSION['err']);
}

// 受け取った$_SESSION['email']を変数に格納
if(isset($_SESSION['email'])) {
  $email = $_SESSION['email'];

  unset($_SESSION['email']);
}

// 受け取った$_SESSION['year']を変数に格納
if(isset($_SESSION['year'])) {
  $year = $_SESSION['year'];

  unset($_SESSION['year']);
}

// 受け取った$_SESSION['month']を変数に格納
if(isset($_SESSION['month'])) {
  $month = $_SESSION['month'];

  unset($_SESSION['month']);
}

// 受け取った$_SESSION['day']を変数に格納
if(isset($_SESSION['day'])) {
  $day = $_SESSION['day'];

  unset($_SESSION['day']);
}

// 受け取った$_SESSION['tel']を変数に格納
if(isset($_SESSION['tel'])) {
  $tel = $_SESSION['tel'];

  unset($_SESSION['tel']);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link rel="stylesheet" href="../css/create_user.css">
  <title>Milfin_create_account</title>
</head>
<body>
  <section class="sp_site">
    <header>
      <!-- トップ -->
      <div class="top">
        <h2 class="milfin">Milfin</h2>
        <nav>
          <div class="top_menu">
            <a href="../php/favorite.php" class="favorite">
              <span class="material-icons top_menu_icon" id="favorite">favorite</span>
            </a>
            <a href="../php/shopping_cart.php" class="shopping_cart">
              <span class="material-icons top_menu_icon" id="shopping_cart">shopping_cart</span>
            </a>
            <span class="material-icons top_menu_icon menu" id="menu">menu</span>
          </div>
        </nav>
      </div>
      <!-- 商品検索機能 -->
      <div class="search">
        <form action="./complete_create_user.php" method="POST">
          <input type="text" name="serach" id="sp_search" placeholder="何かお探しですか？" autocomplete="off">
          <input type="submit" name="submit" id="sp_submit" value="&#xf002;" class="fas">
        </form>
      </div>
      <!-- タブメニュー -->
      <div class="mask"></div>
      <div class="window">
        <ul>
          <li><a href="./index.php">トップへ</a></li>
          <li><a href="./login_form.php">ログイン</a></li>
          <li><a href="">よくある質問</a></li>
          <li><a href="./contact_form.php">お問い合わせ</a></li>
        </ul>
      </div>
    </header>

    <div class="create">
      <span class="material-icons" id="person">person</span>
      <h3>新規会員登録</h3>
    </div>

    <!-- フォームに関する記述 -->
    <form class="create_form" action="./complete_create_user.php" method="POST" >
      <div class="info">
        <h3>基本情報</h3>
      </div>
      <!-- 生年月日に関する記述 -->
      <div class="birthday">
        <div>
          <p class="title">生年月日</p>
        </div>
        <?php if(!isset($year) && !isset($month) && !isset($day)) :?>
        <div class="select">
          <select name="year" id="year">
            <option value="">-</option>
            <option value="1900">1900</option>
            <option value="1901">1901</option>
            <option value="1902">1902</option>
            <option value="1903">1903</option>
            <option value="1904">1904</option>
            <option value="1905">1905</option>
            <option value="1906">1906</option>
            <option value="1907">1907</option>
            <option value="1908">1908</option>
            <option value="1909">1909</option>
            <option value="1910">1910</option>
            <option value="1911">1911</option>
            <option value="1912">1912</option>
            <option value="1913">1913</option>
            <option value="1914">1914</option>
            <option value="1915">1915</option>
            <option value="1916">1916</option>
            <option value="1917">1917</option>
            <option value="1918">1918</option>
            <option value="1919">1919</option>
            <option value="1920">1920</option>
            <option value="1921">1921</option>
            <option value="1922">1922</option>
            <option value="1923">1923</option>
            <option value="1924">1924</option>
            <option value="1925">1925</option>
            <option value="1926">1926</option>
            <option value="1927">1927</option>
            <option value="1928">1928</option>
            <option value="1929">1929</option>
            <option value="1930">1930</option>
            <option value="1931">1931</option>
            <option value="1932">1932</option>
            <option value="1933">1933</option>
            <option value="1934">1934</option>
            <option value="1935">1935</option>
            <option value="1936">1936</option>
            <option value="1937">1937</option>
            <option value="1938">1938</option>
            <option value="1939">1939</option>
            <option value="1940">1940</option>
            <option value="1941">1941</option>
            <option value="1942">1942</option>
            <option value="1943">1943</option>
            <option value="1944">1944</option>
            <option value="1945">1945</option>
            <option value="1946">1946</option>
            <option value="1947">1947</option>
            <option value="1948">1948</option>
            <option value="1949">1949</option>
            <option value="1950">1950</option>
            <option value="1951">1951</option>
            <option value="1952">1952</option>
            <option value="1953">1953</option>
            <option value="1954">1954</option>
            <option value="1955">1955</option>
            <option value="1956">1956</option>
            <option value="1957">1957</option>
            <option value="1958">1958</option>
            <option value="1959">1959</option>
            <option value="1960">1960</option>
            <option value="1961">1961</option>
            <option value="1962">1962</option>
            <option value="1963">1963</option>
            <option value="1964">1964</option>
            <option value="1965">1965</option>
            <option value="1966">1966</option>
            <option value="1967">1967</option>
            <option value="1968">1968</option>
            <option value="1969">1969</option>
            <option value="1970">1970</option>
            <option value="1971">1971</option>
            <option value="1972">1972</option>
            <option value="1973">1973</option>
            <option value="1974">1974</option>
            <option value="1975">1975</option>
            <option value="1976">1976</option>
            <option value="1977">1977</option>
            <option value="1978">1978</option>
            <option value="1979">1979</option>
            <option value="1980">1980</option>
            <option value="1981">1981</option>
            <option value="1982">1982</option>
            <option value="1983">1983</option>
            <option value="1984">1984</option>
            <option value="1985">1985</option>
            <option value="1986">1986</option>
            <option value="1987">1987</option>
            <option value="1988">1988</option>
            <option value="1989">1989</option>
            <option value="1990">1990</option>
            <option value="1991">1991</option>
            <option value="1992">1992</option>
            <option value="1993">1993</option>
            <option value="1994">1994</option>
            <option value="1995">1995</option>
            <option value="1996">1996</option>
            <option value="1997">1997</option>
            <option value="1998">1998</option>
            <option value="1999">1999</option>
            <option value="2000">2000</option>
            <option value="2001">2001</option>
            <option value="2002">2002</option>
            <option value="2003">2003</option>
            <option value="2004">2004</option>
            <option value="2005">2005</option>
            <option value="2006">2006</option>
            <option value="2007">2007</option>
            <option value="2008">2008</option>
            <option value="2009">2009</option>
            <option value="2010">2010</option>
            <option value="2011">2011</option>
            <option value="2012">2012</option>
            <option value="2013">2013</option>
            <option value="2014">2014</option>
            <option value="2015">2015</option>
            <option value="2016">2016</option>
            <option value="2017">2017</option>
            <option value="2018">2018</option>
            <option value="2019">2019</option>
            <option value="2020">2020</option>
            <option value="2021">2021</option>
            <option value="2022">2022</option>
            <option value="2023">2023</option>
            <option value="2024">2024</option>
            <option value="2025">2025</option>
            <option value="2026">2026</option>
            <option value="2027">2027</option>
            <option value="2028">2028</option>
            <option value="2029">2029</option>
            <option value="2030">2030</option>
          </select>年
          <select name="month" id="month">
            <option value="">-</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
            <option value="6">6</option>
            <option value="7">7</option>
            <option value="8">8</option>
            <option value="9">9</option>
            <option value="10">10</option>
            <option value="11">11</option>
            <option value="12">12</option>
          </select>月
          <select name="day" id="day">
            <option value="">-</option>
            <option value="1">01</option>
            <option value="2">02</option>
            <option value="3">03</option>
            <option value="4">04</option>
            <option value="5">05</option>
            <option value="6">06</option>
            <option value="7">07</option>
            <option value="8">08</option>
            <option value="9">09</option>
            <option value="10">10</option>
            <option value="11">11</option>
            <option value="12">12</option>
            <option value="13">13</option>
            <option value="14">14</option>
            <option value="15">15</option>
            <option value="16">16</option>
            <option value="17">17</option>
            <option value="18">18</option>
            <option value="19">19</option>
            <option value="20">20</option>
            <option value="21">21</option>
            <option value="22">22</option>
            <option value="23">23</option>
            <option value="24">24</option>
            <option value="25">25</option>
            <option value="26">26</option>
            <option value="27">27</option>
            <option value="28">28</option>
            <option value="29">29</option>
            <option value="30">30</option>
            <option value="31">31</option>
          </select>日
        </div>
        <?php endif ;?>
        <?php if(isset($year) && isset($month) && isset($day)) :?>
        <div class="select">
          <select name="year" id="year">
          <?php if(isset($year)) :?>
            <option value=""<?php if($year === "");?>>-</option>
            <option value="1900"<?php if($year === "1900") echo "selected" ;?>>1900</option>
            <option value="1901"<?php if($year === "1901") echo "selected" ;?>>1901</option>
            <option value="1902"<?php if($year === "1902") echo "selected" ;?>>1902</option>
            <option value="1903"<?php if($year === "1903") echo "selected" ;?>>1903</option>
            <option value="1904"<?php if($year === "1904") echo "selected" ;?>>1904</option>
            <option value="1905"<?php if($year === "1905") echo "selected" ;?>>1905</option>
            <option value="1906"<?php if($year === "1906") echo "selected" ;?>>1906</option>
            <option value="1907"<?php if($year === "1907") echo "selected" ;?>>1907</option>
            <option value="1908"<?php if($year === "1908") echo "selected" ;?>>1908</option>
            <option value="1909"<?php if($year === "1909") echo "selected" ;?>>1909</option>
            <option value="1910"<?php if($year === "1910") echo "selected" ;?>>1910</option>
            <option value="1911"<?php if($year === "1911") echo "selected" ;?>>1911</option>
            <option value="1912"<?php if($year === "1912") echo "selected" ;?>>1912</option>
            <option value="1913"<?php if($year === "1913") echo "selected" ;?>>1913</option>
            <option value="1914"<?php if($year === "1914") echo "selected" ;?>>1914</option>
            <option value="1915"<?php if($year === "1915") echo "selected" ;?>>1915</option>
            <option value="1916"<?php if($year === "1916") echo "selected" ;?>>1916</option>
            <option value="1917"<?php if($year === "1917") echo "selected" ;?>>1917</option>
            <option value="1918"<?php if($year === "1918") echo "selected" ;?>>1918</option>
            <option value="1919"<?php if($year === "1919") echo "selected" ;?>>1919</option>
            <option value="1920"<?php if($year === "1920") echo "selected" ;?>>1920</option>
            <option value="1921"<?php if($year === "1921") echo "selected" ;?>>1921</option>
            <option value="1922"<?php if($year === "1922") echo "selected" ;?>>1922</option>
            <option value="1923"<?php if($year === "1923") echo "selected" ;?>>1923</option>
            <option value="1924"<?php if($year === "1924") echo "selected" ;?>>1924</option>
            <option value="1925"<?php if($year === "1925") echo "selected" ;?>>1925</option>
            <option value="1926"<?php if($year === "1926") echo "selected" ;?>>1926</option>
            <option value="1927"<?php if($year === "1927") echo "selected" ;?>>1927</option>
            <option value="1928"<?php if($year === "1928") echo "selected" ;?>>1928</option>
            <option value="1929"<?php if($year === "1929") echo "selected" ;?>>1929</option>
            <option value="1930"<?php if($year === "1930") echo "selected" ;?>>1930</option>
            <option value="1931"<?php if($year === "1931") echo "selected" ;?>>1931</option>
            <option value="1932"<?php if($year === "1932") echo "selected" ;?>>1932</option>
            <option value="1933"<?php if($year === "1933") echo "selected" ;?>>1933</option>
            <option value="1934"<?php if($year === "1934") echo "selected" ;?>>1934</option>
            <option value="1935"<?php if($year === "1935") echo "selected" ;?>>1935</option>
            <option value="1936"<?php if($year === "1936") echo "selected" ;?>>1936</option>
            <option value="1937"<?php if($year === "1937") echo "selected" ;?>>1937</option>
            <option value="1938"<?php if($year === "1938") echo "selected" ;?>>1938</option>
            <option value="1939"<?php if($year === "1939") echo "selected" ;?>>1939</option>
            <option value="1940"<?php if($year === "1940") echo "selected" ;?>>1940</option>
            <option value="1941"<?php if($year === "1941") echo "selected" ;?>>1941</option>
            <option value="1942"<?php if($year === "1942") echo "selected" ;?>>1942</option>
            <option value="1943"<?php if($year === "1943") echo "selected" ;?>>1943</option>
            <option value="1944"<?php if($year === "1944") echo "selected" ;?>>1944</option>
            <option value="1945"<?php if($year === "1945") echo "selected" ;?>>1945</option>
            <option value="1946"<?php if($year === "1946") echo "selected" ;?>>1946</option>
            <option value="1947"<?php if($year === "1947") echo "selected" ;?>>1947</option>
            <option value="1948"<?php if($year === "1948") echo "selected" ;?>>1948</option>
            <option value="1949"<?php if($year === "1949") echo "selected" ;?>>1949</option>
            <option value="1950"<?php if($year === "1950") echo "selected" ;?>>1950</option>
            <option value="1951"<?php if($year === "1951") echo "selected" ;?>>1951</option>
            <option value="1952"<?php if($year === "1952") echo "selected" ;?>>1952</option>
            <option value="1953"<?php if($year === "1953") echo "selected" ;?>>1953</option>
            <option value="1954"<?php if($year === "1954") echo "selected" ;?>>1954</option>
            <option value="1955"<?php if($year === "1955") echo "selected" ;?>>1955</option>
            <option value="1956"<?php if($year === "1956") echo "selected" ;?>>1956</option>
            <option value="1957"<?php if($year === "1957") echo "selected" ;?>>1957</option>
            <option value="1958"<?php if($year === "1958") echo "selected" ;?>>1958</option>
            <option value="1959"<?php if($year === "1959") echo "selected" ;?>>1959</option>
            <option value="1960"<?php if($year === "1960") echo "selected" ;?>>1960</option>
            <option value="1961"<?php if($year === "1961") echo "selected" ;?>>1961</option>
            <option value="1962"<?php if($year === "1962") echo "selected" ;?>>1962</option>
            <option value="1963"<?php if($year === "1963") echo "selected" ;?>>1963</option>
            <option value="1964"<?php if($year === "1964") echo "selected" ;?>>1964</option>
            <option value="1965"<?php if($year === "1965") echo "selected" ;?>>1965</option>
            <option value="1966"<?php if($year === "1966") echo "selected" ;?>>1966</option>
            <option value="1967"<?php if($year === "1967") echo "selected" ;?>>1967</option>
            <option value="1968"<?php if($year === "1968") echo "selected" ;?>>1968</option>
            <option value="1969"<?php if($year === "1969") echo "selected" ;?>>1969</option>
            <option value="1970"<?php if($year === "1970") echo "selected" ;?>>1970</option>
            <option value="1971"<?php if($year === "1971") echo "selected" ;?>>1971</option>
            <option value="1972"<?php if($year === "1972") echo "selected" ;?>>1972</option>
            <option value="1973"<?php if($year === "1973") echo "selected" ;?>>1973</option>
            <option value="1974"<?php if($year === "1974") echo "selected" ;?>>1974</option>
            <option value="1975"<?php if($year === "1975") echo "selected" ;?>>1975</option>
            <option value="1976"<?php if($year === "1976") echo "selected" ;?>>1976</option>
            <option value="1977"<?php if($year === "1977") echo "selected" ;?>>1977</option>
            <option value="1978"<?php if($year === "1978") echo "selected" ;?>>1978</option>
            <option value="1979"<?php if($year === "1979") echo "selected" ;?>>1979</option>
            <option value="1980"<?php if($year === "1980") echo "selected" ;?>>1980</option>
            <option value="1981"<?php if($year === "1981") echo "selected" ;?>>1981</option>
            <option value="1982"<?php if($year === "1982") echo "selected" ;?>>1982</option>
            <option value="1983"<?php if($year === "1983") echo "selected" ;?>>1983</option>
            <option value="1984"<?php if($year === "1984") echo "selected" ;?>>1984</option>
            <option value="1985"<?php if($year === "1985") echo "selected" ;?>>1985</option>
            <option value="1986"<?php if($year === "1986") echo "selected" ;?>>1986</option>
            <option value="1987"<?php if($year === "1987") echo "selected" ;?>>1987</option>
            <option value="1988"<?php if($year === "1988") echo "selected" ;?>>1988</option>
            <option value="1989"<?php if($year === "1989") echo "selected" ;?>>1989</option>
            <option value="1990"<?php if($year === "1990") echo "selected" ;?>>1990</option>
            <option value="1991"<?php if($year === "1991") echo "selected" ;?>>1991</option>
            <option value="1992"<?php if($year === "1992") echo "selected" ;?>>1992</option>
            <option value="1993"<?php if($year === "1993") echo "selected" ;?>>1993</option>
            <option value="1994"<?php if($year === "1994") echo "selected" ;?>>1994</option>
            <option value="1995"<?php if($year === "1995") echo "selected" ;?>>1995</option>
            <option value="1996"<?php if($year === "1996") echo "selected" ;?>>1996</option>
            <option value="1997"<?php if($year === "1997") echo "selected" ;?>>1997</option>
            <option value="1998"<?php if($year === "1998") echo "selected" ;?>>1998</option>
            <option value="1999"<?php if($year === "1999") echo "selected" ;?>>1999</option>
            <option value="2000"<?php if($year === "2000") echo "selected" ;?>>2000</option>
            <option value="2001"<?php if($year === "2001") echo "selected" ;?>>2001</option>
            <option value="2002"<?php if($year === "2002") echo "selected" ;?>>2002</option>
            <option value="2003"<?php if($year === "2003") echo "selected" ;?>>2003</option>
            <option value="2004"<?php if($year === "2004") echo "selected" ;?>>2004</option>
            <option value="2005"<?php if($year === "2005") echo "selected" ;?>>2005</option>
            <option value="2006"<?php if($year === "2006") echo "selected" ;?>>2006</option>
            <option value="2007"<?php if($year === "2007") echo "selected" ;?>>2007</option>
            <option value="2008"<?php if($year === "2008") echo "selected" ;?>>2008</option>
            <option value="2009"<?php if($year === "2009") echo "selected" ;?>>2009</option>
            <option value="2010"<?php if($year === "2010") echo "selected" ;?>>2010</option>
            <option value="2011"<?php if($year === "2011") echo "selected" ;?>>2011</option>
            <option value="2012"<?php if($year === "2012") echo "selected" ;?>>2012</option>
            <option value="2013"<?php if($year === "2013") echo "selected" ;?>>2013</option>
            <option value="2014"<?php if($year === "2014") echo "selected" ;?>>2014</option>
            <option value="2015"<?php if($year === "2015") echo "selected" ;?>>2015</option>
            <option value="2016"<?php if($year === "2016") echo "selected" ;?>>2016</option>
            <option value="2017"<?php if($year === "2017") echo "selected" ;?>>2017</option>
            <option value="2018"<?php if($year === "2018") echo "selected" ;?>>2018</option>
            <option value="2019"<?php if($year === "2019") echo "selected" ;?>>2019</option>
            <option value="2020"<?php if($year === "2020") echo "selected" ;?>>2020</option>
            <option value="2021"<?php if($year === "2021") echo "selected" ;?>>2021</option>
            <option value="2022"<?php if($year === "2022") echo "selected" ;?>>2022</option>
            <option value="2023"<?php if($year === "2023") echo "selected" ;?>>2023</option>
            <option value="2024"<?php if($year === "2024") echo "selected" ;?>>2024</option>
            <option value="2025"<?php if($year === "2025") echo "selected" ;?>>2025</option>
            <option value="2026"<?php if($year === "2026") echo "selected" ;?>>2026</option>
            <option value="2027"<?php if($year === "2027") echo "selected" ;?>>2027</option>
            <option value="2028"<?php if($year === "2028") echo "selected" ;?>>2028</option>
            <option value="2029"<?php if($year === "2029") echo "selected" ;?>>2029</option>
            <option value="2030"<?php if($year === "2030") echo "selected" ;?>>2030</option>
          <?php endif ;?>
          </select> 年
          <select name="month" id="month">
          <?php if(isset($month)):?>
            <option value=""  <?php if($month === "") echo "selected";?>>-</option>
            <option value="1" <?php if($month === "1") echo "selected";?>>1</option>
            <option value="2" <?php if($month === "2") echo "selected";?>>2</option>
            <option value="3" <?php if($month === "3") echo "selected";?>>3</option>
            <option value="4" <?php if($month === "4") echo "selected";?>>4</option>
            <option value="5" <?php if($month === "5") echo "selected";?>>5</option>
            <option value="6" <?php if($month === "6") echo "selected";?>>6</option>
            <option value="7" <?php if($month === "7") echo "selected";?>>7</option>
            <option value="8" <?php if($month === "8") echo "selected";?>>8</option>
            <option value="9" <?php if($month === "9") echo "selected";?>>9</option>
            <option value="10" <?php if($month === "10") echo "selected";?>>10</option>
            <option value="11" <?php if($month === "11") echo "selected";?>>11</option>
            <option value="12" <?php if($month === "12") echo "selected";?>>12</option>
          <?php endif ;?>
          </select> 月
          <select name="day" id="day">
          <?php if(isset($day)):?>
            <option value="" <?php if($day === "") echo "selected";?>>-</option>
            <option value="1" <?php if($day === "1") echo "selected";?>>01</option>
            <option value="2" <?php if($day === "2") echo "selected";?>>02</option>
            <option value="3" <?php if($day === "3") echo "selected";?>>03</option>
            <option value="4" <?php if($day === "4") echo "selected";?>>04</option>
            <option value="5" <?php if($day === "5") echo "selected";?>>05</option>
            <option value="6" <?php if($day === "6") echo "selected";?>>06</option>
            <option value="7" <?php if($day === "7") echo "selected";?>>07</option>
            <option value="8" <?php if($day === "8") echo "selected";?>>08</option>
            <option value="9" <?php if($day === "9") echo "selected";?>>09</option>
            <option value="10" <?php if($day === "10") echo "selected";?>>10</option>
            <option value="11" <?php if($day === "11") echo "selected";?>>11</option>
            <option value="12" <?php if($day === "12") echo "selected";?>>12</option>
            <option value="13" <?php if($day === "13") echo "selected";?>>13</option>
            <option value="14" <?php if($day === "14") echo "selected";?>>14</option>
            <option value="15" <?php if($day === "15") echo "selected";?>>15</option>
            <option value="16" <?php if($day === "16") echo "selected";?>>16</option>
            <option value="17" <?php if($day === "17") echo "selected";?>>17</option>
            <option value="18" <?php if($day === "18") echo "selected";?>>18</option>
            <option value="19" <?php if($day === "19") echo "selected";?>>19</option>
            <option value="20" <?php if($day === "20") echo "selected";?>>20</option>
            <option value="21" <?php if($day === "21") echo "selected";?>>21</option>
            <option value="22" <?php if($day === "22") echo "selected";?>>22</option>
            <option value="23" <?php if($day === "23") echo "selected";?>>23</option>
            <option value="24" <?php if($day === "24") echo "selected";?>>24</option>
            <option value="25" <?php if($day === "25") echo "selected";?>>25</option>
            <option value="26" <?php if($day === "26") echo "selected";?>>26</option>
            <option value="27" <?php if($day === "27") echo "selected";?>>27</option>
            <option value="28" <?php if($day === "28") echo "selected";?>>28</option>
            <option value="29" <?php if($day === "29") echo "selected";?>>29</option>
            <option value="30" <?php if($day === "30") echo "selected";?>>30</option>
            <option value="31" <?php if($day === "31") echo "selected";?>>31</option>
          <?php endif ;?>
          </select> 日
        </div>
        <?php endif ;?>
        <div class="err">
          <?php if(isset($err['birthday'])) :?>
            <p id="err_msg"><?php echo '※'.$err['birthday'] ;?></p>
          <?php endif ;?>
        </div>
          <p class="desc">※登録していただくと誕生日の月に使えるお得なクーポンを受け取ることが可能になります。</p>
      </div>

      <!-- メールアドレスに関する記述 -->
      <div class="email">
        <p class="title">メールアドレス <span>※必須</span></p>
        <input type="email" name="email" id="email" autocomplete="on"
        <?php if(isset($email)) :?>
        value="<?php echo $email ;?>"
        <?php endif ;?>>
        <div class="err">
          <?php if(isset($err['email'])) :?>
            <p id="err_msg"><?php echo '※'.$err['email'] ;?></p>
          <?php endif ;?>
        </div>
        <div class="desc">
          <input type="checkbox" name="checkbox" id="checkbox" checked>
          <p>クーポンおよびショップに関する情報を受け取る</p>
        </div>
      </div>

      <!-- 電話番号に関する記述 -->
      <div class="tel">
        <p class="title">電話番号</p>
        <p class="title_desc">ハイフンなし電話番号を記入して下さい</p>
        <input type="tel" name="tel" id="tel" autocomplete="on" 
        <?php if(isset($tel)) :?>
          value="<?php echo $tel ;?>"
        <?php endif ;?>>
        <div class="err">
          <?php if(isset($err['tel'])) :?>
            <p id="err_msg"><?php echo '※'.$err['tel'] ;?></p>
          <?php endif ;?>
        </div>
        <p class="desc">※設定していただくとパスワードをお忘れの際、パスワードの設定がスムーズにおこなえます。</p>
      </div>

      <!-- パスワードに関する記述 -->
      <div class="password">
        <p class="title">パスワード <span>※必須</span></p>
        <p class="desc">半角英数字をそれぞれ1種類以上含む8文字以上100文字以下</p>
        <input type="password" name="password" id="password">
        <div class="err">
          <?php if(isset($err['password'])) :?>
            <p id="err_msg"><?php echo '※'.$err['password'] ;?></p>
          <?php endif ;?>
        </div>
      </div>

      <!-- 確認用パスワードに関する記述 -->
      <div class="password_conf">
        <p class="title">確認用パスワード <span>※必須</span></p>
        <input type="password" name="password_conf" id="password_conf">
        <div class="err">
          <?php if(isset($err['password_conf'])) :?>
            <p id="err_msg"><?php echo '※'.$err['password_conf'] ;?></p>
          <?php endif ;?>
        </div>
      </div>

      <!-- トークンに関する記述 -->
      <div class="token">
        <input type="hidden" name="token" value="<?php echo User::h(User::setToken()) ;?>">
      </div>

      <!-- 送信に関する記述 -->
      <div class="submit">
        <input type="submit" name="submit" id="submit" value="登録完了">
      </div>
    </form>
  </section>

  <section class="pc-site">
    <header>
      <div class="top">
        <h1 class="milfin">Milfin</h1>
        <nav>
          <div class="top_menu">
            <a href="../php/favorite.php" class="favorite">
              <span class="material-icons top_menu_icon" id="favorite">favorite</span>
            </a>
            <a href="../php/shopping_cart.php" class="shopping_cart">
              <span class="material-icons top_menu_icon" id="shopping_cart">shopping_cart</span>
            </a>
            <span class="material-icons top_menu_icon menu" id="menu">menu</span>
          </div>
        </nav>
      </div>
      <!-- 商品検索機能 -->
      <div class="search">
        <form action="">
          <input type="text" name="serach" id="pc_search" placeholder="何かお探しですか？" autocomplete="off">
          <input type="submit" name="submit" id="pc_submit" value="&#xf002;" class="fas">
        </form>
      </div>
      <!-- タブメニュー -->
      <div class="mask"></div>
      <div class="window">
        <?php if(!isset($login_user)) :?>
        <ul>
          <li><a href="./create_user.php">新規登録</a></li>
          <li><a href="./login_form.php">ログイン</a></li>
          <li><a href="">よくある質問</a></li>
          <li><a href="./contact_form.php">お問い合わせ</a></li>
        </ul>
        <?php endif ;?>
        <?php if(isset($login_user)) :?>   
        <ul>
          <li><a href="./my_page.php">アカウント情報</a></li>
          <li><a href="">購入履歴</a></li>
          <li><a href="">よくある質問</a></li>
          <li><a href="./contact_form.php">お問い合わせ</a></li>
          <li><a href="./logout.php" id="logout">ログアウト</a></li>
        </ul>
        <?php endif ;?>
      </div>
    </header>
  </section>

  <script src="../js/create_user.js"></script>
</body>
</html>