<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'About';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>

1. Stworzenie repozytorium gita na bitbuket i wysłanie tam projektu opisanego poniżej;<br>
2. Z wykorzystaniem frameworka Yii i bazy danych MySQL napisanie projektu który:<br>

	a) Umożliwi użytkownikowi zalogowanie się<br>
	b) Wymusi na użytkowniku zmianę hasła po N dniach (niech N będzie parametrem w kodzie).<br>
	c) Zalogowanemu użytkownikowi pozwoli zaimportować plik XLS zawierający 4 kolumny:<br>
Imię, <br>
Nazwisko, <br>
E-mail, <br>
Datę urodzenia.<br>

Dla każdego wiersza będącego w pliku w systemie zostanie utworzone nowe konto użytkownika <br>
a na adres e-mail wysłane zostanie wygenerowane automatycznie (losowe) hasło i zapisany zostanie czas utworzenia konta.<br>
Każdy użytkownik utworzony w ten sposób ma mieć możliwość zalogowania się i ponownego wykonania importu.<br>

	d) Zalogowanemu użytkownikowi pozwoli na przeglądanie listy innych użytkowników.<br>

========================================================================================================================

      <br>  This is the About page. You may modify the following file to customize its content:
    </p>

    <code><?= __FILE__ ?></code>
</div>
