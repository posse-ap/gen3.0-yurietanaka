<?php
/* ドライバ呼び出しを使用して MySQL データベースに接続する */
$dsn = 'mysql:host=db;dbname=webapp;charset=utf8;';
$user = 'root';
$password = 'root';

try {
    $dbh = new PDO($dsn, $user, $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //////////  webapp ////////////////////
    // hoursテーブルを持ってきて配列に挿入
    $sql_dateid_hours = 'SELECT date_id FROM hours';
    $dateid_hours = $dbh->query($sql_dateid_hours)->fetchAll(PDO::FETCH_ASSOC);



    $sql_hour_hours = 'SELECT hours FROM hours';
    $hour_hours = $dbh->query($sql_hour_hours)->fetchAll(PDO::FETCH_ASSOC);


    // contentsテーブルを持ってきて配列に挿入
    $sql_contents = 'SELECT * FROM contents';
    $contents = $dbh->query($sql_contents)->fetchAll(PDO::FETCH_ASSOC);

    // languagesテーブルを持ってきて配列に挿入
    $sql_languages = 'SELECT * FROM languages';
    $languages = $dbh->query($sql_languages)->fetchAll(PDO::FETCH_ASSOC);


    // 日付ごとの学習時間を算出して，日付と学習時間の配列を持つ2次元配列を作成する
    /////////// 棒グラフ用のデータをテーブルから持ってくる //////////////
    class Study
    {
        public $day;
        public $hours;

        public function get_day()
        {
            return $this->day;
        }

        public function get_hours()
        {
            return (int)$this->hours;
        }
    }

    $date_sql = "SELECT DATE_FORMAT(hours.date, '%Y-%m-%d') day, sum(hours.hours) hours FROM hours group by day having day > '2023-01-00' and day < '2023-01-32' ";
    $date = $dbh->query($date_sql)->fetchAll(\PDO::FETCH_CLASS, Study::class);


    // ここに日付と学習時間の配列を持つ2次元配列を作成している.
    $formatted_study_var_data = array_map(function ($study) {
        return [$study->get_day(), $study->get_hours()];
    }, $date);
    $chart_var_data = json_encode($formatted_study_var_data);






    //////////////// パイグラフ用のデータをテーブルから持ってくる //////////
    // 学習コンテンツ用のデータ
    class Contents
    {
        public $content;
        public $hours;

        public function get_content()
        {
            return $this->content;
        }

        public function get_hours()
        {
            return (int)$this->hours;
        }
    }

    $contents_sql = "SELECT contents.content, sum(hours.hours) hours from hoursContents join contents on hoursContents.contents_id = contents.id join hours on hoursContents.hours_id = hours.id Where hours_id > 11 group by contents.content";

    $content_data = $dbh->query($contents_sql)->fetchAll(\PDO::FETCH_CLASS, Contents::class);



    $formatted_content_pai_data = array_map(function ($study) {
        return [$study->get_content(), $study->get_hours()];
    }, $content_data);

    $content_pai_data = json_encode($formatted_content_pai_data, JSON_UNESCAPED_UNICODE);



    // 学習言語用のデータ

    class Languages
    {
        public $language;
        public $hours;

        public function get_language()
        {
            return $this->language;
        }

        public function get_hours()
        {
            return (int)$this->hours;
        }
    }

    $languages_sql = "SELECT sum(hours.hours) hours ,languages.language from hoursLanguages join languages on hoursLanguages.languages_id = languages.id join hours on hoursLanguages.hours_id = hours.id where hours_id > 11 group by languages.language";

    $language_data = $dbh->query($languages_sql)->fetchAll(\PDO::FETCH_CLASS, Languages::class);

    $formatted_language_pai_data = array_map(function ($study) {
        return [$study->get_language(), $study->get_hours()];
    }, $language_data);
    $language_pai_data = json_encode($formatted_language_pai_data, JSON_UNESCAPED_UNICODE);
} catch (PDOException $e) {
    echo '接続失敗: ' . $e->getMessage();
    exit();
}
