"use strict";
(function(G) {
    //Globals
    var i = 0,
        isShuffled = false;

    var getRandomInt = function(min, max) {
        return Math.floor(Math.random() * (max - min + 1)) + min;
    };

    var shuffle = function(a) {
        var j, x, i;

        for (i = a.length; i; i -= 1) {
            j = Math.floor(Math.random() * i);
            x = a[i - 1];
            a[i - 1] = a[j];
            a[j] = x;
        }

        isShuffled = true;
    };

    ad1_notify.stat = {
        visitors: getRandomInt(1000, 2000),
        online: getRandomInt(50, 120),
        sales: getRandomInt(90, 120)
    };

    ad1_notify.RU = {
        cities: ["Москва", "Санкт-Петербург", "Новосибирск", "Екатеринбург", "Нижний Новгород", "Казань", "Челябинск", "Омск", "Самара", "Ростов-на-Дону", "Уфа", "Красноярск", "Пермь", "Воронеж", "Волгоград", "Саратов", "Краснодар", "Тольятти", "Тюмень", "Ижевск", "Барнаул", "Иркутск", "Ульяновск", "Хабаровск", "Владивосток", "Ярославль", "Махачкала", "Томск", "Оренбург", "Новокузнецк", "Кемерово", "Рязань", "Астрахань", "Набережные Челны", "Пенза", "Липецк", "Киров", "Тула", "Чебоксары", "Калининград", "Курск", "Ставрополь", "Магнитогорск", "Тверь", "Иваново", "Брянск", "Севастополь", "Сочи", "Белгород", "Нижний", "Владимир", "Архангельск", "Калуга", "Сургут", "Чита", "Симферополь", "Смоленск", "Волжский", "Курган", "Орёл", "Череповец", "Вологда", "Мурманск", "Саранск", "Якутск", "Тамбов", "Грозный", "Стерлитамак", "Кострома", "Петрозаводск", "Нижневартовск", "Йошкар-Ола", "Новороссийск", "Балашиха", "Таганрог", "Комсомольск"],
        peoples: [
            ["Домаш Вячеслав", "Лагутов Руслан", "Степанков Радислав", "Перешивкин Ростислав", "Кобзев Платон", "Кабанов Игнатий", "Чепурин Николай", "Крымов Изяслав", "Собчак Евгений", "Былинкин Максим", "Архипов Сергей", "Донцов Самсон", "Стаин Владилен", "Лызлов Владислав", "Ягужинский Аристарх", "Фризов Владимир", "Крупнов Дмитрий", "Ябловский Вадим", "Гусенков Самсон", "Панфёров Семён", "Ясинский Павел", "Тетерев Глеб", "Шлыков Николай", "Козлов Илья", "Амалиев Максим", "Паулкин Ефим", "Колганов Герман", "Саламатов Николай", "Сподарев Степан", "Бочкарёв Владимир", "Опекунов Вячеслав", "Телицын Тимофей", "Ямлиханов Андрей", "Малиновский Владислав", "Гребнев Ростислав", "Кузанов Леонид", "Ягфаров Серафим", "Цитников Всеволод", "Владимиров Артём", "Банин Александр", "Капица Кирилл", "Колбин Клавдий", "Володин Зиновий", "Уланов Иван", "Седых Кирилл", "Туровский Лев", "Яснов Ефим", "Москвин ﻿Артем", "Измайлов Герман", "Цыганов Егор", "Голумбовский Дмитрий", "Аничков Кирилл", "Канаш Степан", "Клепахов Дмитрий", "Колесников Анатолий", "Цветков Леонид", "Мишин Ефим", "Борисов Митрофан"],
            ["Иноземцева Надежда", "Тотенкова Регина", "Курдина Эмилия", "Стаина Анна", "Чуличкова Анастасия", "Шеркова Евгения", "Андрюхина Нина", "Катериночкина Анфиса", "Головина Анна", "Чупрова Екатерина", "Холопова Виктория", "Крупина Мария", "Полевщикова Кристина", "Пьянкова Диана", "Буланова Яна", "Цейдлерина Мария", "Щеголева Светлана", "Янкелевич Алина", "Якушевич Наталья", "Фомичева Диана", "Пережогина Виктория", "Ячменькова Василиса", "Рябова Дарья", "Домышева Юлия", "Милова Татьяна", "Шипицына Анна", "Протасова Евгения", "Молодыха Алиса", "Коржева Ксения", "Кузнецова Вероника", "Сукина Алиса", "Перова ﻿Агата", "Коржакова Ольга", "Ёжина Вероника", "Абрамович Валентина", "Крылова Наталья", "Проскуркина Александра", "Терехова Юлия", "Труфанова Варвара", "Батурина Марина", "Васнецова Нина", "Перевалова Надежда", "Рошета Любовь", "Мосякова Татьяна", "Носова Анастасия", "Типалова Юнона", "Колесникова Инесса", "Якуничева Анна", "Левина Евгения", "Агафонова Виктория", "Дуркина Антонина", "Игошина Мария", "Званцова Светлана", "Хлопонина Елена", "Суботина Изабелла", "Дроздова Марфа", "Милютина Изабелла", "Гнусарева Ангелина"]
        ]
    };

    ad1_notify.RS = {
        cities: ["Београд", "Нови Сад", "Приштина", "Ниш", "Крагујевац", "Суботица", "Панчево", "Зрењанин", "Чачак", "Краљево", "Нови Пазар", "Лесковац", "Смедерево", "Врање", "Ужице", "Ваљево", "Крушевац", "Шабац", "Пожаревац", "Сомбор", "Пирот", "Зајечар", "Кикинда", "Сремска Митровица", "Јагодина", "Вршац", "Лозница"],
        peoples: [
            ["Aleksa", "Aleksandar", "Filip", "Jovan", "Lazar", "Luka", "Marko", "Milos", "Nemanja", "Nikola", "Ognjen", "Stefan", "Uros", "Vuk"],
            ["Ana", "Andela", "Anja", "Iva", "Jana", "Jelena", "Jovana", "Katarina", "Marija", "Masa", "Milica", "Sara", "Sofija", "Teodora"]
        ]
    };

    ad1_notify.PL = {
        cities: ["Gdynia", "Poznań", "Gduńsk", "Toruń", "Kraków", "Katowice", "Wrocław", "Warszawa", "Olsztyn", "Gliwice", "Szczecin", "Łódź", "Zakopane", "Białystok", "Lublin"],
        peoples: [
            ["Adok", "Aleksy", "Andrzej", "Borys", "Boryslaw", "Bernardyn", "Cezary", "Czeslaw", "Dobieslaw", "Dariusz", "Eugeniusz", "Francizek", "Fredek", "Gerek", "Izak", "Jozef", "Janek", "Kajetan", "Piotr", "Patryk", "Stanislaw", "Vincenty"],
            ["Anka", "Adelajda", "Amelja", "Bohdana", "Cecylja", "Celina", "Danica", "Elzbieta", "Ewa", "Franciszka", "Felka", "Gizela", "Hilaria", "Izabel", "Jadwiga", "Katrin", "Krystka", "Laurka", "Lucja", "Mila", "Mela", "Natka", "Truda"]
        ]
    };

    var buildDeliveryPopup = function(params) {
        var city = (params.city.length) ? 'г.&nbsp;' + params.city : 'Вашем городе',
            country = (ad1_notify[params.geoKey] && params.geoKey !== 'ZZ') ? params.geoKey : 'RU',
            $html = $('<div class="delivery-notify">' +
            '<button class="close-delivery-notify">&times;</button>' +
            '<div class="notify-text"></div>' +
            '</div>');

        if (params.zdorov == 1) {
            $html = $('<div class="zd_dostavka">' +
                '<img class="zd_dostavka_flag" src="/files/_blocks/notificators/img/zdorov/flags/' + params.geoKey + '.png" alt=""/>' +
                '<p class="text"></p>' +
                '</div><div class="bottom_menu">' +
                '<div class="container contaner_bottom_menu">' +
                '<img class="zd_dostavka_flag" src="/files/_blocks/notificators/img/zdorov/flags/' + params.geoKey + '.png" alt=""/>' +
                '<div class="fast_send text"></div>' +
                '</div>' +
                '</div>');

            var str = {
                RU: function() {
                    $html.find('.text').html('<strong>БЫСТРАЯ<br> Доставка</strong><br><span class="zd_text"> в ' + city + '</span>');
                },

                ZZ: function() {
                    $html.find('.text').html('<strong>БЫСТРАЯ<br> Доставка</strong><br><span class="zd_text"> в ' + city + '</span>');
                },

                AZ: function() {
                    $html.find('.text').html('<strong>sürətli<br>çatdırılma</strong><br><span class="zd_text">Azərbaycanda</span>');
                },

                KZ: function() {
                    $html.find('.text').html('<strong>Бүкіл</strong><br><span class="zd_text">Қазақстан<br>ЖЕДЕЛ ЖЕТКІЗУ</span>');
                },

                PL: function() {
                    $html.find('.text').html('<strong>Бүкіл</strong><br><span class="zd_text">Қазақстан<br>ЖЕДЕЛ ЖЕТКІЗУ</span>');
                }
            };

            str[country]();
            return $html;

        } else if (params.zdorov == 2) {
            $html = $('<div class="zd_dostavka">' +
                '<img class="zd_dostavka_top" src="img/zdorov/zd_dostavka.png"/*tpa=http://seven-phone.ru/files/_blocks/notificators/img/zdorov/zd_dostavka.png*/ alt=""/>' +
                '<img class="zd_dostavka_flag" src="/files/_blocks/notificators/img/zdorov/flags/' + params.geoKey + '.png" alt=""/>' +
                '<p class="text"></p></div>' +
                '<div class="zd_buy_button">' +
                '<div class="zd_buy_button_desktop button_text"></div>' +
                '<div class="zd_buy_button_mobile"><div class="button_text"></div></div>' +
                '</div>');

            var str = {
                RU: function() {
                    $html.find('.text').html('<span>Быстрая доставка</span> по всей России').end().find('.button_text').html('ЗАКАЗАТЬ<br>ПРЯМО СЕЙЧАС');
                },

                PL: function() {
                    $html.find('.text').html('<span>Быстрая доставка</span> по всей Польше').end().find('.button_text').html('ЗАКАЗАТЬ<br>ПРЯМО СЕЙЧАС');
                },

                ZZ: function() {
                    $html.find('.text').html('<span>Быстрая доставка</span> по всей России').end().find('.button_text').html('ЗАКАЗАТЬ<br>ПРЯМО СЕЙЧАС');
                },

                AZ: function() {
                    $html.find('.text').html('<span>Быстрая доставка</span> по всему Азербайджану').end().find('.button_text').html('Indi<br>sifariş etmək');
                },

                KZ: function() {
                    $html.find('.text').html('<span>Быстрая доставка</span> по всему Казахстану').end().find('.button_text').html('Дəл қазір тапсырыс жасау');
                },

                BY: function() {
                    $html.find('.text').html('<span>Быстрая доставка</span> по всей Беларусии').end().find('.button_text').html('ЗАКАЗАТЬ<br>ПРЯМО СЕЙЧАС');
                },

                UA: function() {
                    $html.find('.text').html('<span>Быстрая доставка</span> по всей Украине').end().find('.button_text').html('ЗАКАЗАТЬ<br>ПРЯМО СЕЙЧАС');
                }
            };

            $(function() {
                var $orderBlock = $('.orderformcdn:first'),
                    $div = $('.zd_dostavka'),
                    $button = $('.zd_buy_button');

                $html.on('click', function() {
                    $('html, body').stop().animate({
                        scrollTop: ($orderBlock.offset().top)
                    }, 1000);
                });

                setTimeout(setInterval(function() {
                    if ($div.is(':visible')) {
                        $div.fadeOut(function() {
                            $button.fadeIn();
                        });
                    } else {
                        $button.fadeOut(function() {
                            $div.fadeIn();
                        });
                    }
                }, 3500), 3000);
            });
            str[country]();
            return $html;
        }

        var str = {
            RU: function() {
                $html.find('.notify-text').html('Действует быстрая доставка в ' + city);
            },

            PL: function() {
                $html.find('.notify-text').html('Istnieje możliwość szybkiej dostawa do Twojego miasta.');
            }
        };

        (str[country]) ? str[country]() : str['RU']();

        return $html;
    };

    var buildSaleTips = function(params) {
        var qty = (params.multiply) ? getRandomInt(1, params.multiply) : 0,
            bill = (!params.multiply) ? params.price : params.price * qty,
            country = (ad1_notify[params.geoKey] && params.geoKey !== 'ZZ') ? params.geoKey : 'RU',
            city = ad1_notify[country].cities[getRandomInt(0, ad1_notify[country].cities.length - 1)],
            sex = (ad1_notify.params.sex !== 'any') ? ad1_notify.params.sex : getRandomInt(0, 1),
            names = [],
            name = '',
            text;

        names = ad1_notify[country].peoples[sex];
        !isShuffled && shuffle(names);
        name = names[i];

        if (i == names.length - 1)
            i = 0;
        i++;

        text = {
            RU: {
                qtyStr: (qty > 0) ? ', кол-во&nbsp;' + qty + '&nbsp;шт.' : '',
                notify_text: name + ', ' + city + ', сделал' + (sex > 0 ? 'а' : '') + ' заказ на&nbsp;' + bill + '&nbsp;' + params.currency
            },

            RS: {
                qtyStr: '',
                notify_text: name + ' je naprav' + (sex > 0 ? 'ila' : 'io') + ' narudžbinu za ' + bill + '&nbsp;' + params.currency
            },

            PL: {
                qtyStr: '',
                notify_text: name + ' złożył' + (sex > 0 ? 'a' : '') + ' zamówienie na sumę ' + bill + '&nbsp;' + params.currency
            },
        };

        return (
            '<div class="buyers-notify">' +
            '<div class="buyers-icon"></div>' +
            '<div class="notify-text">' + text[country].notify_text + ' ' + text[country].qtyStr + '</div>' +
            '</div>'
        );
    };


    var buildVisitorsPanel = function(geoKey) {
        var $html = $('<div id="visitors-panel">' +
            '<ul class="visitors-info"> ' +
            '<li class="visitors-today"></li>' +
            '<li class="visitors-now"></li>' +
            '<li class="visitors-buy"></li>' +
            '</ul>' +
            '</div>'),
            str;

        str =  {
            RU: function(){
                $html.find('.visitors-today').html('<i class="vis-ico"><img src="img/all.png"/*tpa=http://seven-phone.ru/files/_blocks/notificators/img/all.png*/ alt="" /></i> Посетителей сегодня: <span>' + ad1_notify.stat.visitors + '</span>');
                $html.find('.visitors-now').html('<i class="vis-ico"><img src="img/now.png"/*tpa=http://seven-phone.ru/files/_blocks/notificators/img/now.png*/ alt="" /></i> Сейчас на сайте: <span>' + ad1_notify.stat.online + '</span>');
                $html.find('.visitors-buy').html('<i class="vis-ico"><img src="img/buy.png"/*tpa=http://seven-phone.ru/files/_blocks/notificators/img/buy.png*/ alt="" /></i> Покупок сегодня: <span>' + ad1_notify.stat.sales + '</span>');
            },

            PL: function(){
                $html.find('.visitors-today').html('<i class="vis-ico"><img src="img/all.png"/*tpa=http://seven-phone.ru/files/_blocks/notificators/img/all.png*/ alt="" /></i> Dzisiejsze odwiedziny: <span>' + ad1_notify.stat.visitors + '</span>');
                $html.find('.visitors-now').html('<i class="vis-ico"><img src="img/now.png"/*tpa=http://seven-phone.ru/files/_blocks/notificators/img/now.png*/ alt="" /></i> Goście online: <span>' + ad1_notify.stat.online + '</span>');
                $html.find('.visitors-buy').html('<i class="vis-ico"><img src="img/buy.png"/*tpa=http://seven-phone.ru/files/_blocks/notificators/img/buy.png*/ alt="" /></i> Dzisiejsze zakupy: <span>' + ad1_notify.stat.sales + '</span>');
            }
        };

        (str[geoKey]) ? str[geoKey]() : str['RU']();

        return $html;
    };

    var buildFreezer = function(geoKey) {
        var freezed = {
            RU: '= 45 рублей',
            PL: 'Według kursu z 2014 roku'
        };

        var price = (freezed[geoKey]) ? freezed[geoKey] : 'по курсу 2014 года';

        var $html = $('<div class="freezing-wrap">' +
            '<div class="freezing-info">' +
            '<div class="freezing-info--title"></div>' +
            '<div class="freezing-info--price">1$ <span class="dynamic-freezing-info--price">' + price + '</span></div>' +
            '<div class="freezing-info--packages"></div>' +
            '</div>');

        var str = {
            RU: function(){
                $html.find('.freezing-info--title').html('Мы заморозили цену!');
                $html.find('.freezing-info--packages').html('Осталось <span class="packages-count lastpack">132</span> шт. <br>по старому курсу</div>' + '<a href="#close" class="freezing-close"></a>');
            },

            PL: function(){
                $html.find('.freezing-info--title').html('ZAMROZILIŚMY CENY!');
                $html.find('.freezing-info--packages').html('Zostało <span class="packages-count lastpack">132</span> szt. <br>wg starego kursu</div>' + '<a href="#close" class="freezing-close"></a>');
            }
        };

        (str[geoKey]) ? str[geoKey]() : str['RU']();

        return $html;
    };

    var buildOnlineUsersPanel = function() {
        var online_users = ad1_notify.stat.online - 1,
            text = {
                RU: 'Сейчас ' + online_users + ' пользователей просматривают эту страницу вместе с вами.',
                ZZ: 'Сейчас ' + online_users + ' пользователей просматривают эту страницу вместе с вами.',
                RS: online_users + ' korisnik trenutno pregledava ovu stranicu zajedno sa vama.',
                PL: 'Obecnie włącznie z Państwem przegląda tę stronę ' + online_users + ' osób.'
            };

        var geoText = text[ad1_notify.params.geoKey] || 'Сейчас ' + online_users + ' пользователей просматривают эту страницу вместе с вами.';


        return (
            '<div class="online-users-panel">' +
            '<button class="close-online-users-panel" type="button">&times;</button>' +
            '<div class="online-users-panel-text">' + geoText + '</div>' +
            '</div>'
        );
    };


    var AD1 = G.AD1 || {
        showDeliveryPopup: function() {
            try {
                var $popup = $(buildDeliveryPopup(ad1_notify.params));

                $popup.find('.close-delivery-notify').on('click', function(e) {
                    $popup.remove();
                });

                $('body').append($popup);

            } catch (e) {
                console.log(e);
            }
        },

        showSaleTips: function() {
            try {
                var $tip = $(buildSaleTips(ad1_notify.params));
                $('body').append($tip);

                setTimeout(function() {
                    $tip.fadeOut(400, function() {
                        $tip.remove();
                    });
                }, 5000);

            } catch (e) {
                console.log(e);
            }
        },

        showVisitorsPanel: function() {
            try {
                $('body').prepend(buildVisitorsPanel(ad1_notify.params.geoKey));
            } catch (e) {
                console.log(e);
            }
        },

        showFreezer: function() {
            try {
                $('body').prepend(buildFreezer(ad1_notify.params.geoKey));

                setTimeout(function() {
                    $('.freezing-wrap').addClass('freezing-active');
                    $('html').addClass('freezer');
                }, 2000);

                setTimeout(function() {
                    $('.freezing-wrap').removeClass('freezing-active');
                    $('html').removeClass('freezer');
                }, 30000);

                $('.freezing-close').on('click', function(e) {
                    e.preventDefault();
                    $('.freezing-wrap').addClass('freezing-hide');
                    $('html').removeClass('freezer');
                });


            } catch (e) {
                console.log(e);
            }
        },

        showOnlineUsersPanel: function() {
            try {
                var $onlineUsersPanel = $(buildOnlineUsersPanel());

                $onlineUsersPanel.find('.close-online-users-panel').on('click', function() {
                    $onlineUsersPanel.hide();
                });

                $('body').append($onlineUsersPanel);
            } catch (e) {
                console.log(e);
            }
        }
    };

    G.AD1 = AD1;
})(this);