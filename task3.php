<!-- Модифицирована система из 1 задания. Добавлен счетчик попыток входа с блокировкой в случае превышения количества неправильных
попыток. Также проводится проверка установлены ли параметры username и password в GET-запросе -->
<?php
session_start(); 

$maxLoginAttempts = 3; 
$blockedTime = 60; 

if( isset( $_GET[ 'Login' ] ) ) {
  // Проверить, не превысило ли количество попыток входа максимальное значение
  if(isset($_SESSION['loginAttempts']) && $_SESSION['loginAttempts'] >= $maxLoginAttempts) {
    // Пользователь заблокирован на некоторое время
    if(isset($_SESSION['blockTime']) && $_SESSION['blockTime'] > time()) {
      $html .= "<pre><br />You have exceeded the maximum number of login attempts. Please try again later.</pre>";
      exit; // Прервать выполнение скрипта
    } else {
      // Пользователь разблокирован, сбросить счетчик попыток входа
      unset($_SESSION['loginAttempts']);
      unset($_SESSION['blockTime']);
    }
  }
  // Get username
  if( isset( $_GET[ 'username' ] ) ) {
    $user = $_GET[ 'username' ];
  }
  // Get password
  if( isset( $_GET[ 'password' ] ) ) {
    $pass = $_GET[ 'password' ];
    $pass = md5( $pass );
  } 
  
// Если логин неуспешен, увеличить счетчик попыток входа
  if(!isset($html) || empty($html)) { // Проверить, прошел ли пользователь проверку на аутентификацию
    if(isset($_SESSION['loginAttempts'])) {
      $_SESSION['loginAttempts']++;
    } else {
      $_SESSION['loginAttempts'] = 1;
    }

    // Если достигнуто максимальное количество попыток входа, установить время блокировки
    if($_SESSION['loginAttempts'] >= $maxLoginAttempts) {
      $_SESSION['blockTime'] = time() + $blockedTime;
    }
  }
}
?>