<?
$aMenuLinks = Array(
	Array(
		"Главная", 
		"/", 
		Array(), 
		Array(), 
		"" 
	),
	Array(
		"Мои альбомы", 
		"/albums/", 
		Array(), 
		Array(), 
		"CSite::InGroup(array(1,3,4,5))" 
	),
	Array(
		"Добавить альбом", 
		"/albums/add_album/", 
		Array(), 
		Array(), 
		"CSite::InGroup(array(1,3,4,5))" 
	),
	Array(
		"Выход", 
		"/?logout=yes", 
		Array(), 
		Array(), 
		"CSite::InGroup(array(1,3,4,5))" 
	),
	Array(
		"Авторизация", 
		"/auth/", 
		Array(), 
		Array(), 
		"!\$USER->IsAuthorized();" 
	)
);
?>