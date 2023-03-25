<?php
require('./dbconnect.php');
$contents_date_array = array();
$contents_content_array = array();
// まず今日のデータを検索し、今日の勉強時間を出す
// アクセス時の日付を取得
$objDateTime = new DateTime();
// 使える形に加工
$today = $objDateTime->format('Y' . 'm' . 'd');
// 今日の日付をwhereで絞って取得
$sql_today = 'SELECT * FROM hours WHERE date_id = :today';
$today_stmt = $dbh->prepare($sql_today);
$today_stmt->bindValue(':today', $today);
$today_stmt->execute();
$result_todays = $today_stmt->fetchAll();
// 今日の日付を定義
$today_sum = 0;
foreach ($result_todays as $key => $result_today) {
  $today_sum += $result_today["hours"];
}
// $result_todayに今日の学習時間の合計を代入
$result_today["day_sum"] = $today_sum;

// $today_sumに今日の合計が入る

// 今月のデータを検索し、今月の勉強時間を出す
$this_month = $objDateTime->format('Y/m');
$this_month_first = $objDateTime->format('Y' . 'm' . '00');
$sql_this_month = 'SELECT * FROM hours WHERE date_id BETWEEN :this_month_first AND :today';
$month_stmt = $dbh->prepare($sql_this_month);
$month_stmt->bindValue(':this_month_first', $this_month_first);
$month_stmt->bindValue(':today', $today);
$month_stmt->execute();
$result_monthes = $month_stmt->fetchAll();
$month_sum = 0;
foreach ($result_monthes as $result_month) {
  $month_sum += $result_month["hours"];
}

// $month_sumに今月の合計が入る

// これまでの勉強時間を算出する
$sql_total_month = 'SELECT * FROM hours WHERE date_id <= :today';
$total_stmt = $dbh->prepare($sql_total_month);
$total_stmt->bindValue(':today', $today);
$total_stmt->execute();
$result_totals = $total_stmt->fetchAll();
$total_sum = 0;

$barData = array();

foreach ($result_totals as $key => $result_total) {
  $total_sum += $result_total["hours"];
  // unset($result_total[0], $result_total["id"], $result_total[1], $result_total[2], $result_total[3], $result_total["date"]);
  // $result_totals[$key] += $result_total;
  // print_r($result_total["date"]);
  array_push($barData, ["day" => $result_total["date"], "time" => $result_total["hours"]]);
};
$barData = json_encode($barData);

// $total_sumに合計の時間が入る
// print_r($today_sum)

$stmt = $dbh->query("SELECT languages_id, SUM(hour) as total_hour FROM stuy_logs GROUP BY languages_id");
$data = $stmt->fetchAll();
$hours = array();
foreach ($data as $row) {
  $hours[$row['languages_id']] = $row['total_hour'];
}

// 存在しないlanguage_idに対しては0をセットする
for ($i = 1; $i <= 8; $i++) {
  if (!isset($hours[$i])) {
    $hours[$i] = 0;
  }
}
$hours_str = implode(",", $hours);


$stmt = $dbh->query("SELECT contents_id, SUM(hour) as total_hour FROM stuy_logs GROUP BY contents_id");
$data = $stmt->fetchAll();
$contents_hours = array();
foreach ($data as $row) {
  $contents_hours[$row['contents_id']] = $row['total_hour'];
}

// 存在しないlanguage_idに対しては0をセットする
for ($i = 1; $i <= 8; $i++) {
  if (!isset($contents_hours[$i])) {
    $contents_hours[$i] = 0;
  }
}
$contents_hours_str = implode(",", $contents_hours);
print_r($contents_hours_str);
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="./style/reset.css">
  <link rel="stylesheet" href="./style/common.css" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/themes/base/jquery-ui.min.css">
  <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous" defer></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js" defer></script>
  <script src="./scripts/modal.js" defer></script>
  <script src="./scripts/calender.js" defer></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0" defer></script>
  <title>ph1-webapp</title>
</head>

<body>
  <!-- headerここから -->
  <header>
    <div class="p-header">
      <div class="p-header__container">
        <div class="p-header__logo">
          <a><img src="./assets/img/logo.svg" alt="" /></a>
          <span>4th week</span>
        </div>
        <div class="p-header__button">
          <button class="p-header__button__inner js-modal-open-button">記録・投稿</button>
        </div>
      </div>
    </div>
  </header>
  <!-- headerここまで -->

  <!-- mainここから -->
  <main>
    <div class="p-main">
      <div class="p-main__contents">
        <div class="p-main__time">
          <div class="p-main__time__item">
            <span>Today</span>
            <span><?php
                  print_r($today_sum)
                  ?></span>
            <span>hour</span>
          </div>
          <div class="p-main__time__item">
            <span>Month</span>
            <span><?php
                  print_r($month_sum)
                  ?></span>
            <span>hour</span>
          </div>
          <div class="p-main__time__item">
            <span>Total</span>
            <span><?php
                  print_r($total_sum)
                  ?></span>
            <span>hour</span>
          </div>
          <div class="p-main__time__chart">
            <div class="p-main__time__chart__container">
              <canvas id="js-bar-chart"></canvas>
              <!-- <script>
                createBarChart(<?php echo $barData ?>)

                function createBarChart(jsonData) {
                  console.log(jsonData)
                  const convertedDayData = jsonData.map((d) => {
                    return d.day;
                  });
                  const convertedTimeData = jsonData.map((d) => {
                    return d.time;
                  });

                  const bar_ctx = document.getElementById("js-bar-chart").getContext("2d");
                  const gradient_desktop = bar_ctx.createLinearGradient(0, 0, 0, 300);
                  const gradient_mobile = bar_ctx.createLinearGradient(0, 0, 0, 100);
                  gradient_desktop.addColorStop(0, "#3ccfff");
                  gradient_desktop.addColorStop(1, "#0f71bc");
                  gradient_mobile.addColorStop(0, "#3ccfff");
                  gradient_mobile.addColorStop(1, "#0f71bc");

                  const barChart = new Chart(bar_ctx, {
                    type: "bar",
                    data: {
                      labels: convertedDayData,
                      datasets: [{
                        data: convertedTimeData,
                        barPercentage: 0.6,
                        backgroundColor: screen.width > 520 ? gradient_desktop : gradient_mobile,
                        borderRadius: 50,
                        borderSkipped: false,
                      }, ],
                    },
                    options: {
                      responsive: true,
                      maintainAspectRatio: false,
                      scales: {
                        x: {
                          grid: {
                            display: false,
                            drawBorder: false,
                            //borderを消す
                          },
                          ticks: {
                            maxRotation: 0,
                            minRotation: 0,
                            //回転させない
                            min: 1,
                            max: 30,
                            color: "#97b9d1",
                            autoSkip: false,
                            //画面を小さくしても、非表示させない
                            callback: function(value, index) {
                              return index % 2 === 1 ? this.getLabelForValue(value) : "";
                            },
                          },
                        },
                        y: {
                          grid: {
                            display: false,
                            drawBorder: false,
                            //borderを消す
                          },
                          max: 8,
                          min: 0,
                          ticks: {
                            stepSize: 2,
                            callback: function(value) {
                              return value + "h";
                            },
                            color: "#97b9d1",
                          },
                        },
                      },
                      plugins: {
                        legend: {
                          display: false,
                        },
                        datalabels: {
                          display: false,
                        },
                      },
                    },
                  });
                }
              </script> -->
            </div>
          </div>
        </div>
        <div class="p-main__studying-data">
          <div class="p-main__studying-data__doughnut">
            <div class="p-main__studying-data__doughnut__container">
              <span class="p-main__studying-data__doughnut__title">学習言語</span>
              <div class="p-main__studying-data__doughnut__content">
                <canvas id="js-doughnut1"></canvas>
              </div>
              <ul class="p-main__studying-data__doughnut__legends" id="js-languages-legends"></ul>
            </div>
          </div>
          <div class="p-main__studying-data__doughnut">
            <div class="p-main__studying-data__doughnut__container">
              <span class="p-main__studying-data__doughnut__title">学習コンテンツ</span>
              <div class="p-main__studying-data__doughnut__content">
                <canvas id="js-doughnut2"></canvas>
              </div>
              <ul class="p-main__studying-data__doughnut__legends" id="js-contents-legends"></ul>
            </div>
          </div>
        </div>
      </div>
      <div class="p-main__change-month">
        <span></span>
        <span>2020年10月</span>
        <span></span>
      </div>
      <div class="p-main__button-mobile">
        <button class="js-modal-open-button">記録・投稿</button>
      </div>
    </div>

    <!-- modalここから -->
    <div class="p-modal js-modal">
      <div class="p-modal__overlay js-overlay"></div>
      <div class="p-modal__container">
        <div class="p-modal__header">
          <button type="button" class="p-modal__close-button js-modal-close-button"></button>
          <button class="p-modal__back-button js-modal-back-button">
            <span class="p-modal__back-button__arrow"></span>
          </button>
        </div>
        <form class="p-modal__inner js-modal-inner">
          <!-- modal左半分ここから -->
          <div class="p-modal__left">
            <dl class="p-modal__left__date">
              <dt>学習日</dt>
              <dd>
                <input type="text" id="datepicker" readonly />
              </dd>
            </dl>
            <dl class="p-modal__left__contents">
              <div class="p-modal__left__contents__title">
                <dt>学習コンテンツ（複数選択可）</dt>
                <span class="p-modal__left__contents__alert js-alert">1項目以上選択してください</span>
              </div>
              <div class="p-modal__left__contents__checkboxes">
                <dd class="c-checkbutton">
                  <input id="checkbox1" class="js-contents-checkbox" type="checkbox" />
                  <label for="checkbox1" class="c-checkbutton__container">
                    <span class="c-checkbutton__dummy-input"></span>
                    N予備校
                  </label>
                </dd>
                <dd class="c-checkbutton">
                  <input id="checkbox2" class="js-contents-checkbox" type="checkbox" />
                  <label for="checkbox2" class="c-checkbutton__container">
                    <span class="c-checkbutton__dummy-input"></span>
                    ドットインストール
                  </label>
                </dd>
                <dd class="c-checkbutton">
                  <input id="checkbox3" class="js-contents-checkbox" type="checkbox" />
                  <label for="checkbox3" class="c-checkbutton__container">
                    <span class="c-checkbutton__dummy-input"></span>
                    POSSE課題
                  </label>
                </dd>
              </div>
            </dl>
            <dl class="p-modal__left__languages">
              <div class="p-modal__left__languages__title">
                <dt>学習言語（複数選択可）</dt>
                <span class="p-modal__left__languages__alert js-alert">1項目以上選択してください</span>
              </div>
              <div class="p-modal__left__languages__checkboxes">
                <dd class="c-checkbutton">
                  <input id="checkbox4" class="js-languages-checkbox" type="checkbox" />
                  <label for="checkbox4" class="c-checkbutton__container">
                    <span class="c-checkbutton__dummy-input"></span>
                    HTML
                  </label>
                </dd>
                <dd class="c-checkbutton">
                  <input id="checkbox5" class="js-languages-checkbox" type="checkbox" />
                  <label for="checkbox5" class="c-checkbutton__container">
                    <span class="c-checkbutton__dummy-input"></span>
                    CSS
                  </label>
                </dd>
                <dd class="c-checkbutton">
                  <input id="checkbox6" class="js-languages-checkbox" type="checkbox" />
                  <label for="checkbox6" class="c-checkbutton__container">
                    <span class="c-checkbutton__dummy-input"></span>
                    JavaScript
                  </label>
                </dd>
                <dd class="c-checkbutton">
                  <input id="checkbox7" class="js-languages-checkbox" type="checkbox" />
                  <label for="checkbox7" class="c-checkbutton__container">
                    <span class="c-checkbutton__dummy-input"></span>
                    PHP
                  </label>
                </dd>
                <dd class="c-checkbutton">
                  <input id="checkbox8" class="js-languages-checkbox" type="checkbox" />
                  <label for="checkbox8" class="c-checkbutton__container">
                    <span class="c-checkbutton__dummy-input"></span>
                    Laravel
                  </label>
                </dd>
                <dd class="c-checkbutton">
                  <input id="checkbox10" class="js-languages-checkbox" type="checkbox" />
                  <label for="checkbox10" class="c-checkbutton__container">
                    <span class="c-checkbutton__dummy-input"></span>
                    SQL
                  </label>
                </dd>
                <dd class="c-checkbutton">
                  <input id="checkbox11" class="js-languages-checkbox" type="checkbox" />
                  <label for="checkbox11" class="c-checkbutton__container">
                    <span class="c-checkbutton__dummy-input"></span>
                    SHELL
                  </label>
                </dd>
                <dd class="c-checkbutton">
                  <input id="checkbox12" class="js-languages-checkbox" type="checkbox" />
                  <label for="checkbox12" class="c-checkbutton__container">
                    <span class="c-checkbutton__dummy-input"></span>
                    情報システム基礎知識（その他)
                  </label>
                </dd>
              </div>
            </dl>
          </div>
          <!-- modal左半分ここまで -->

          <!-- modal右半分ここから -->
          <div class="p-modal__right">
            <dl class="p-modal__right__time">
              <div class="p-modal__right__time__title">
                <dt>学習時間</dt>
                <span class="p-modal__right__time__alert js-alert">学習時間を入力してください</span>
              </div>
              <dd>
                <input type="text" class="js-studying-time js-input-text" placeholder="時間を入力" />
              </dd>
            </dl>
            <dl class="p-modal__right__twitter">
              <div class="p-modal__right__twitter__title">
                <dt>Twitter用コメント</dt>
                <span class="p-modal__right__twitter__alert js-alert">140文字以内で入力してください</span>
              </div>
              <dd>
                <textarea class="js-input-text" id="js-tweet-area" cols="30" rows="10" placeholder="140文字以内で入力"></textarea>
              </dd>
              <div class="p-modal__right__twitter__share">
                <label>
                  <input type="checkbox" class="js-tweet-checkbox" />
                  <span class="p-modal__right__twitter__dummy-input"></span>
                  <span>Twitterにシェアする</span>
                </label>
              </div>
            </dl>
          </div>
          <!-- modal右半分ここまで -->

          <!-- modal記録・投稿ボタンここから -->
          <div class="p-modal__record-button">
            <button type="button" class="p-modal__record-button__inner js-button-record-done">記録・投稿</button>
          </div>
          <!-- modal記録・投稿ボタンここまで -->
        </form>

        <div class="p-modal__nowloading js-now-loading">
          <div class="p-modal__nowloading__inner"></div>
        </div>
        <!-- modal記録・投稿完了表示ここから -->
        <div class="p-modal__record-done js-record-done">
          <span>AWESOME!</span>
          <span class="p-modal__record-done__circle"></span>
          <span>記録・投稿<br />完了しました</span>
        </div>
        <!-- modal記録・投稿完了表示ここまで -->

        <!-- calenderここから -->
        <div class="p-calendar js-calendar">
          <div class="p-calendar__header">
            <span id="js-prev"></span>
            <h1 id="js-title">2022/05</h1>
            <span id="js-next"></span>
          </div>
          <table class="p-calendar__inner">
            <thead>
              <tr class="p-calendar__inner__days">
                <th>Sun</th>
                <th>Mon</th>
                <th>Tue</th>
                <th>Wed</th>
                <th>Thu</th>
                <th>Fri</th>
                <th>Sat</th>
              </tr>
            </thead>
            <tbody id="js-dates"></tbody>
          </table>
          <div class="p-calendar__button">
            <button type="button" class="p-calendar__button__inner js-calendar-button">決定</button>
          </div>
        </div>
        <!-- calenderここまで -->
      </div>
    </div>
    <!-- modalここまで -->
  </main>
  <!-- mainここまで -->
  <script>
    const bgColors = ["#0345ec", "#0f71bd", "#20bdde", "#3ccefe", "#b29ef3", "#6d46ec", "#4a17ef", "#3105c0"];

    const STUDYING_LANGUAGES_DATA = "http://posse-task.anti-pattern.co.jp/1st-work/study_language.json";
    fetch(STUDYING_LANGUAGES_DATA)
      .then((response) => {
        return response.json();
      })
      .then((jsonData) => {
        createLanguagesChart(jsonData);
      });

    function createLanguagesChart(jsonData) {
      const convertedLanguagesData = Object.keys(jsonData[0]);
      const convertedRatioDataOfLanguages = Object.values(jsonData[0]);
      const doughnut1_ctx = document.getElementById("js-doughnut1").getContext("2d");
      const doughnutChart1 = new Chart(doughnut1_ctx, {
        type: "doughnut",
        data: {
          labels: convertedLanguagesData,
          datasets: [{
            data: [<?php echo $hours_str; ?>],
            backgroundColor: bgColors,
            datalabels: {
              color: "#ffffff",
              formatter: function(value, context) {
                return value + "%";
              },
            },
            hoverOffset: 4,
          }, ],
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: {
              display: false,
            },
          },
        },
      });
      const languagesLegendContainer = document.getElementById("js-languages-legends");
      createLegend(convertedLanguagesData, languagesLegendContainer);
    }
    //学習言語ここまで
    //学習コンテンツここから
    const STUDYING_CONTENTS_DATA = "http://posse-task.anti-pattern.co.jp/1st-work/study_contents.json";
    fetch(STUDYING_CONTENTS_DATA)
      .then((response) => {
        return response.json();
      })
      .then((jsonData) => {
        createContentsChart(jsonData);
      });

    function createContentsChart(jsonData) {
      const convertedContentsData = Object.keys(jsonData[0]);
      const convertedRatioDataOfContents = Object.values(jsonData[0]);
      const doughnut2_ctx = document.getElementById("js-doughnut2").getContext("2d");
      const doughnutChart2 = new Chart(doughnut2_ctx, {
        type: "doughnut",
        data: {
          labels: convertedContentsData,
          datasets: [{
            data: [<?php echo $contents_hours_str ?>],
            backgroundColor: bgColors,
            datalabels: {
              color: "#ffffff",
              formatter: function(value, context) {
                return value + "%";
              },
            },
            hoverOffset: 4,
          }, ],
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: {
              display: false,
            },
          },
        },
      });
      const contentsLegendContainer = document.getElementById("js-contents-legends");
      createLegend(convertedContentsData, contentsLegendContainer);
    }
    //学習コンテンツここまで

    function createLegend(data, appendArea) {
      for (let i = 0; i < data.length; i++) {
        const li = document.createElement("li");
        if (data[i] === "その他") {
          li.innerHTML = `<div style="background-color:${bgColors[i]}"></div><span>情報システム基礎知識(${data[i]})</span>`;
        } else {
          li.innerHTML = `<div style="background-color:${bgColors[i]}"></div><span>${data[i]}</span>`;
        }
        appendArea.appendChild(li);
      }
    }
  </script>
</body>

</html>