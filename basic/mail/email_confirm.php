<p>
    <span style="text-align: left; padding-right: 70%; font-size: 24px; font-weight: 600;">ФильтрСБ</span>
    <span style="text-align: right;"><a title="Вход в систему" href="<?=Yii::$app->request->hostInfo ?>/signin">Вход в систему</a></span></p>
<hr />
<p style="text-align: left;">Здравствуйте!</p>
<p style="text-align: left;">Поздравляем с успешной регистрацией на сайте <strong>ФильтрСБ</strong> !</p>
<p style="text-align: left;">Что бы активировать Вашу учетную запись, нажмите кнопку ниже для подтверждения вашего адреса электронной почты.</p>
<p>&nbsp;</p>
<p style="text-align: center;">
    <a style="background-color: #1cc1f7; color: white; text-decoration: none; padding: 10px; cursor: pointer;" title="Активировать учетную запись" href="<?=Yii::$app->request->hostInfo ?>/register/confirm?h=<?=$hash?>">Активировать учетную запись</a>
</p>
<p>&nbsp;</p>
<p style="text-align: left;">Если кнопка не работает скопируйте ссылку ниже в Ваш браузер:</p>
<p style="text-align: center; color: blue;"><?=Yii::$app->request->hostInfo ?>/register/confirm?h=<?=$hash?></p>
<p>&nbsp;</p>
<p style="text-align: left;">Для получения дополнительной информации обратитесь в наш <a title="Центр поддержки." href="<?=Yii::$app->request->hostInfo ?>">Центр поддержки.</a></p>