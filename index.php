<?php
/**
 * Реализовать проверку заполнения обязательных полей формы в предыдущей
 * с использованием Cookies, а также заполнение формы по умолчанию ранее
 * введенными значениями.
 */
// Отправляем браузеру правильную кодировку,
// файл index.php должен быть в кодировке UTF-8 без BOM.
header('Content-Type: text/html; charset=UTF-8');

// В суперглобальном массиве $_SERVER PHP сохраняет некторые заголовки запроса HTTP
// и другие сведения о клиненте и сервере, например метод текущего запроса $_SERVER['REQUEST_METHOD'].
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  // Массив для временного хранения сообщений пользователю.
  $messages = array();

  // В суперглобальном массиве $_COOKIE PHP хранит все имена и значения куки текущего запроса.
  // Выдаем сообщение об успешном сохранении.
  if (!empty($_COOKIE['save'])) {
    // Удаляем куку, указывая время устаревания в прошлом.
    setcookie('save', '', 100000);
    // Если есть параметр save, то выводим сообщение пользователю.
    $messages[] = 'Спасибо, результаты сохранены.';
  }

  // Складываем признак ошибок в массив.
  $errors = array();
 
  $errors['name'] = !empty($_COOKIE['name_error']);
  $errors['tel'] = !empty($_COOKIE['tel_error']) ;
  $errors['email'] = !empty($_COOKIE['email_error']);
  $errors['data'] = !empty($_COOKIE['data_error']) ;
  $errors['pol'] = !empty($_COOKIE['pol_error']);
  $errors['languages'] = !empty($_COOKIE['languages_error']);
  $errors['bio'] = !empty($_COOKIE['bio_error']);
  $errors['agreement'] = !empty($_COOKIE['agreement_error']);
  // TODO: аналогично все поля.

  // Выдаем сообщения об ошибках.
  if ($errors['name']) {
    // Удаляем куку, указывая время устаревания в прошлом.
    setcookie('name_error', '', 100000);
    // Выводим сообщение.
    $messages['name'] = '<div class="error">Заполните имя, оно должно быть латинскими буквами; содержать только буквы и пробелы и быть не длиннее 150 символов, </div>';
  }
  if ($errors['tel']) {
    // Удаляем куку, указывая время устаревания в прошлом.
    setcookie('tel_error', '', 100000);
    // Выводим сообщение.
    $messages['tel'] = '<div class="error"> Телефон должен быть формата +7 000 000 00 00 </div>';
  }
  if ($errors['email']) {
    // Удаляем куку, указывая время устаревания в прошлом.
    setcookie('email_error', '', 100000);
    // Выводим сообщение.
    $messages['email'] = '<div class="error"> Почта должна быть формата pochta@gmail.com </div>';
  }
  if ($errors['data']) {
    // Удаляем куку, указывая время устаревания в прошлом.
    setcookie('data_error', '', 100000);
    // Выводим сообщение.
    $messages['data'] = '<div class="error"> Выберите дату рождения</div>';
  }
  if ($errors['pol']) {
    // Удаляем куку, указывая время устаревания в прошлом.
    setcookie('pol_error', '', 100000);
    // Выводим сообщение.
    $messages['pol'] = '<div class="error">Выберите пол  </div>';
  }
  if ($errors['languages']) {
    // Удаляем куку, указывая время устаревания в прошлом.
    setcookie('languages_error', '', 100000);
    // Выводим сообщение.
    $messages['languages'] = '<div class="error"> Выберите языки </div>';
  }
  if ($errors['bio']) {
    // Удаляем куку, указывая время устаревания в прошлом.
    setcookie('bio_error', '', 100000);
    // Выводим сообщение.
    $messages['bio'] = '<div class="error"> Напишите биографию</div>';
  }
  if ($errors['agreement']) {
    // Удаляем куку, указывая время устаревания в прошлом.
    setcookie('agreement_error', '', 100000);
    // Выводим сообщение.
    $messages['agreement'] = '<div class="error">Поставьте галочку</div>';
  }
  // TODO: тут выдать сообщения об ошибках в других полях.

  // Складываем предыдущие значения полей в массив, если есть.
  $values = array();
  $values['name'] = empty($_COOKIE['name_value']) ? '' : $_COOKIE['name_value'];
  $values['tel'] = empty($_COOKIE['tel_value']) ? '' : $_COOKIE['tel_value'];
  $values['email'] = empty($_COOKIE['email_value']) ? '' : $_COOKIE['email_value'];
  $values['data'] = empty($_COOKIE['data_value']) ? '' : $_COOKIE['data_value'];
  $values['pol'] = empty($_COOKIE['pol_value']) ? '' : $_COOKIE['pol_value'];
  $values['languages'] = empty($_COOKIE['languages_value']) ? [] : json_decode($_COOKIE['languages_value'], true);
  $values['bio'] = empty($_COOKIE['bio_value']) ? '' : $_COOKIE['bio_value'];
  $values['agreement'] = empty($_COOKIE['agreement_value']) ? '' : $_COOKIE['agreement_value'];
  // TODO: аналогично все поля.

  // Включаем содержимое файла form.php.
  // В нем будут доступны переменные $messages, $errors и $values для вывода 
  // сообщений, полей с ранее заполненными данными и признаками ошибок.
  include('form.php');
}
// Иначе, если запрос был методом POST, т.е. нужно проверить данные и сохранить их в XML-файл.
else {
  // Проверяем ошибки.
  $errors = FALSE;
  if (empty($_POST['name']) || !preg_match('/^[a-zA-Z\s]{1,150}$/', $_POST['name'])) {
    // Выдаем куку на день с флажком об ошибке в поле fio.
    setcookie('name_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else {
    // Сохраняем ранее введенное в форму значение на месяц.
    setcookie('name_value', $_POST['name'], time() + 30 * 24 * 60 * 60);
  }
  if (empty($_POST['tel']) || !is_numeric($_POST['tel']) || !preg_match('/^((8|\+7)[\- ]?)?(\(?\d{3}\)?[\- ]?)?[\d\- ]{7}$/', $_POST['tel'])) {
    setcookie('tel_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else {
    // Сохраняем ранее введенное в форму значение на месяц.
    setcookie('tel_value', $_POST['tel'], time() + 30 * 24 * 60 * 60);
  }
  
  if (empty($_POST['email']) ||  !preg_match('/^([a-z0-9_-]+\.)*[a-z0-9_-]+@[a-z0-9_-]+(\.[a-z0-9_-]+)*\.[a-z]{2,6}$/i', $_POST['email']) ) {
    setcookie('email_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else {
    // Сохраняем ранее введенное в форму значение на месяц.
    setcookie('email_value', $_POST['email'], time() + 30 * 24 * 60 * 60);
  }
  
  if (empty($_POST['data']) ||  !preg_match('/^[0-9]{4}-(0[1-9]|1[012])-(0[1-9]|1[0-9]|2[0-9]|3[01])$/', $_POST['data']) ) {
    setcookie('data_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else {
    // Сохраняем ранее введенное в форму значение на месяц.
    setcookie('data_value', $_POST['data'], time() + 30 * 24 * 60 * 60);
  }
  if (!isset($_POST['pol']) || !in_array($_POST['pol'], array('male', 'female'))) {
    setcookie('pol_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else {
    // Сохраняем ранее введенное в форму значение на месяц.
    setcookie('pol_value', $_POST['pol'], time() + 30 * 24 * 60 * 60);
  }
  $valid_languages = array("100", "101", "102", "103", "104", "105", "106", "107", "108", "109", "110");
  if (!isset($_POST['languages'])) {
    setcookie('languages_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  } 
  else {
      foreach ($_POST['languages'] as $langu) {
          if ( !in_array($langu, $valid_languages)) {
            setcookie('languages_error', '1', time() + 24 * 60 * 60);
            $errors = TRUE;
            break;
          }
      }
      if (!$errors) {
        setcookie('languages_value', json_encode($_POST['languages']), time() + 30 * 24 * 60 * 60);
    }
  }
  
  if (empty($_POST['bio']) ) {
    setcookie('bio_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else {
    // Сохраняем ранее введенное в форму значение на месяц.
    setcookie('bio_value', $_POST['bio'], time() + 30 * 24 * 60 * 60);
  }
  if(!isset($_POST['agreement']) || $_POST['agreement'] != 'on') {
    setcookie('agreement_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else {
    // Сохраняем ранее введенное в форму значение на месяц.
    setcookie('agreement_value', $_POST['agreement'], time() + 30 * 24 * 60 * 60);
  }

// *************
// TODO: тут необходимо проверить правильность заполнения всех остальных полей.
// Сохранить в Cookie признаки ошибок и значения полей.
// *************

  if ($errors) {
    // При наличии ошибок перезагружаем страницу и завершаем работу скрипта.
    header('Location: index.php');
    exit();
  }
  else {
    // Удаляем Cookies с признаками ошибок.
    setcookie('name_error', '', 100000);
    setcookie('tel_error', '', 100000);
    setcookie('email_error', '', 100000);
    setcookie('data_error', '', 100000);
    setcookie('pol_error', '', 100000);
    setcookie('languages_error', '', 100000);
    setcookie('bio_error', '', 100000);
    setcookie('agreement_error', '', 100000);
    // TODO: тут необходимо удалить остальные Cookies.
  }

  // Сохранение в БД.
  // ...
include ('conf.php');
  $db = new PDO('mysql:host=localhost;dbname=u67432', $user, $pass,
    [PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

    try {
      //  $stmt = $db->prepare("INSERT INTO application SET name = ?");
      //  $stmt->execute([$_POST['name']]);
        $stmt = $db->prepare("INSERT INTO application (name, tel, email, data, pol, bio, agreement) VALUES (?, ?, ?, ?, ?, ?, ?)");
          $stmt->execute([
              $_POST['name'],
              $_POST['tel'],
              $_POST['email'],
              $_POST['data'],
              $_POST['pol'],
              $_POST['bio'],
              $_POST['agreement']
          ]);
          $application_id = $db->lastInsertId();
          foreach ($_POST['languages'] as $language) {
            $stmt = $db->prepare("INSERT INTO programming_language (languages) VALUES (?)");
            $stmt->execute([$language]);
      
            $programming_language_id = $db->lastInsertId();
      
            $stmt = $db->prepare("INSERT INTO application_programming_language (application_id, programming_language_id) VALUES (?, ?)");
            $stmt->execute([$application_id, $programming_language_id]);
          }
      }
      catch(PDOException $e){
        print('Error : ' . $e->getMessage());
        exit();
      }
  // Сохраняем куку с признаком успешного сохранения.
  setcookie('save', '1');

  // Делаем перенаправление.
  header('Location: index.php');
}
