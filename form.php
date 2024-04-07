
<!DOCTYPE html>
<html lang="ru">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="bootstrap.min.css" rel="stylesheet">
    
    <title>задание 2.4.</title>
    <link rel="stylesheet" href="style.css">
  </head>

  <body>

<?php


// if (!empty($messages)) {
//   print('<div id="messages">');
//   // Выводим все сообщения.
//   foreach ($messages as $message) {
//     print($message);
//   }
//   print('</div>');
// }

// Далее выводим форму отмечая элементы с ошибками классом error
// и задавая начальные значения элементов ранее сохраненными.
?>

<div class=" m-5 row d-flex ">
        <div class="col-12 d-flex justify-content-center p-2">
            <div class="form-popup col-10 m-5" id="myForm">
                <form action="index.php" method="POST" id="form" class="form_body">
                    <div class="form_item">
                    <?php if (!empty($messages['name'])) { print $messages['name']; } ?>
                        <input placeholder="Ваше имя"  class="form_input _req <?php if ($errors['name']) { print 'error'; } ?>" type="text" name="name" value="<?php print $values['name']; ?>">
                    </div>
                    <div class="form_item">
                    <?php if (!empty($messages['tel'])) { print $messages['tel']; } ?>
                        <input  placeholder="Телефон" class="form_input _req _tel <?php if ($errors['tel']) { print 'error'; } ?>" type="text" name="tel"  value="<?php print $values['tel']; ?>">
                    </div>
                    <div class="form_item">
                    <?php if (!empty($messages['email'])) { print $messages['email']; } ?>
                        <input placeholder="E-mail" class="form_input _req _email <?php if ($errors['email']) { print 'error'; } ?>" type="text" name="email"  value="<?php print $values['email']; ?>" >
                    </div>
                    <div class="form_item">
                    <?php if (!empty($messages['data'])) { print $messages['data']; } ?>
                        <input name="data" class="form_input _req _date <?php if ($errors['data']) { print 'error'; } ?> " type="date"   placeholder="Введите дату рождения" value="<?php print $values['data']; ?>">
                    </div>
                    <div class="form_item">
                    <?php if (!empty($messages['pol'])) { print $messages['pol']; } ?>
                        <div class="form_input3 <?php if ($errors['pol']) { print 'error'; } ?> "><b>Ваш пол</b></p>
                            <p><input name="pol"  type="radio" value="female" <?php if ($values['pol'] == 'female') {print 'checked';} ?>> женский</p>
                            <p><input name="pol" type="radio" value="male" <?php if ($values['pol'] == 'male') {print 'checked';} ?>> мужской</p>
                    </div>
                    <div class="form_item "> 
                    <?php if (!empty($messages['languages'])) { print $messages['languages']; }
                    ?>

                        <select multiple="multiple" class="form_input2 <?php if ($errors['languages']) { print 'error'; } ?> " name="languages[]"  >
                            <option disabled>Выберете ваш любимый язык программирования</option>
                           
                            <option  value="100" <?php if (in_array("100", $values['languages'])) { print 'selected'; } ?>> Pascal</option>
                            <option value="101" <?php if (in_array("101", $values['languages'])) {print 'selected';} ?>> C </option>
                            <option value="102" <?php if (in_array("102", $values['languages'])) {print 'selected';} ?>> C++</option>
                            <option value="103"<?php if (in_array("103", $values['languages'])) {print 'selected';} ?>>JavaScript </option>
                            <option value="104" <?php if (in_array("104", $values['languages'])) {print 'selected';} ?>>PHP</option>
                            <option value="105" <?php if (in_array("105", $values['languages'])) {print 'selected';} ?>>Python</option>
                            <option value="106" <?php if (in_array("106", $values['languages'])) {print 'selected';} ?>>Java</option>
                            <option value="107" <?php if (in_array("107", $values['languages'])) {print 'selected';} ?>>Haskel</option>
                            <option value="108" <?php if (in_array("108", $values['languages'])) {print 'selected';} ?>>Clojure</option>
                            <option value="109" <?php if (in_array("109", $values['languages'])) {print 'selected';} ?>>Prolog</option>
                            <option value="110" <?php if (in_array("110", $values['languages'])) {print 'selected';} ?>>Scala</option>
                        </select>
                    </div>
                    <div class="form_item">
                    <?php if (!empty($messages['bio'])) { print $messages['bio']; } ?>
                    <textarea placeholder="Ваша биография" name="bio" class="form_input <?php if ($errors['bio']) { print 'error'; } ?>"><?php print $values['bio']; ?></textarea>
                    </div>
                    <div class="form_item">
                    <?php if (!empty($messages['agreement'])) { print $messages['agreement']; } ?>
                        <div class="d-flex row m-2 <?php if ($errors['agreement']) {print 'error';} ?> ">
                            <input  class="col-1 checkbox_input  " type="checkbox" name="agreement" value="on" <?php if ($values['agreement'] == 'on') {print 'checked';} ?>>
                            <label for="formAgreement" class="col-10 checkbox_label"> с контрактом ознакомлен</label>
                        </div>
                    </div>
                    <button type="submit" class="form_button" value="on">Сохранить</button>
                    
        
        
                </form>
            </div>
        </div>
    </div>
  </body>
</html>
