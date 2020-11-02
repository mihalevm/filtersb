<p>
    <span style="text-align: left; padding-right: 70%; font-size: 24px; font-weight: 600;">ФильтрСБ</span>
    <span style="text-align: right;"><a title="Вход в систему" href="<?=Yii::$app->request->hostInfo ?>/signin">Вход в систему</a></span></p>
<hr />
<p style="text-align: left;">Здравствуйте!</p>
<p style="text-align: left;">Вы запросили ссылку для восстановления пароля на сайте <strong>ФильтрСБ</strong> !</p>
<p style="text-align: left;">Что бы начать процедуру востановления пароля нажмите на кнопку.</p>
<p style="text-align: left;">Если Вы НЕ пытались восстановить пароль на сайте, то рекомендуем Вам пройти в ЛК сайта и сменить пароль и логин самостоятельно.</p>
<p>&nbsp;</p>
<p style="text-align: center;">
    <a style="background-color: #1cc1f7; color: white; text-decoration: none; padding: 10px; cursor: pointer;" title="Восстановить пароль" href="<?=Yii::$app->request->hostInfo ?>/signin/restore-confirm?h=<?=$hash?>">Восстановить пароль</a>
</p>
<p>&nbsp;</p>
<p style="text-align: left;">Если кнопка не работает скопируйте ссылку ниже в Ваш браузер:</p>
<p style="text-align: center; color: blue;"><?=Yii::$app->request->hostInfo ?>/signin/restore-confirm?h=<?=$hash?></p>
<p>&nbsp;</p>
<p style="text-align: left;">Для получения дополнительной информации обратитесь в наш <a title="Центр поддержки." href="<?=Yii::$app->request->hostInfo ?>">Центр поддержки.</a></p>