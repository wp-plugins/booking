﻿/* Danish initialisation for the jWPDev UI date picker plugin. */
/* Written by Jan Christensen ( deletestuff@gmail.com). */
(function($) {
    $.datepick.regional['da'] = {
		clearText: 'Nulstil', clearStatus: 'Nulstil den aktuelle dato',
		closeText: 'Luk', closeStatus: 'Luk uden ændringer',
        prevText: '&#x3c;Forrige', prevStatus: 'Vis forrige måned',
		prevBigText: '&#x3c;&#x3c;', prevBigStatus: '',
		nextText: 'Næste&#x3e;', nextStatus: 'Vis næste måned',
		nextBigText: '&#x3e;&#x3e;', nextBigStatus: '',
		currentText: 'Idag', currentStatus: 'Vis aktuel måned',
        monthNames: ['Januar','Februar','Marts','April','Maj','Juni',
        'Juli','August','September','Oktober','November','December'],
        monthNamesShort: ['Jan','Feb','Mar','Apr','Maj','Jun',
        'Jul','Aug','Sep','Okt','Nov','Dec'],
		monthStatus: 'Vis en anden måned', yearStatus: 'Vis et andet år',
		weekHeader: 'Uge', weekStatus: 'Årets uge',
		dayNames: ['Søndag','Mandag','Tirsdag','Onsdag','Torsdag','Fredag','Lørdag'],
		dayNamesShort: ['Søn','Man','Tir','Ons','Tor','Fre','Lør'],
		dayNamesMin: ['Sø','Ma','Ti','On','To','Fr','Lø'],
		dayStatus: 'Sæt DD som første ugedag', dateStatus: 'Vælg D, M d',
        dateFormat: 'dd-mm-yy', firstDay: 0,
		initStatus: 'Vælg en dato', isRTL: false,
		showMonthAfterYear: false, yearSuffix: ''};
    $.datepick.setDefaults($.datepick.regional['da']);
})(jWPDev);
