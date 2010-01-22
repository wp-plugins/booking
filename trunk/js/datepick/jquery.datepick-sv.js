﻿/* Swedish initialisation for the jWPDev UI date picker plugin. */
/* Written by Anders Ekdahl ( anders@nomadiz.se). */
(function($) {
    $.datepick.regional['sv'] = {
		clearText: 'Rensa', clearStatus: '',
		closeText: 'Stäng', closeStatus: '',
        prevText: '&laquo;Förra',  prevStatus: '',
		prevBigText: '&#x3c;&#x3c;', prevBigStatus: '',
		nextText: 'Nästa&raquo;', nextStatus: '',
		nextBigText: '&#x3e;&#x3e;', nextBigStatus: '',
		currentText: 'Idag', currentStatus: '',
        monthNames: ['Januari','Februari','Mars','April','Maj','Juni',
        'Juli','Augusti','September','Oktober','November','December'],
        monthNamesShort: ['Jan','Feb','Mar','Apr','Maj','Jun',
        'Jul','Aug','Sep','Okt','Nov','Dec'],
		monthStatus: '', yearStatus: '',
		weekHeader: 'Ve', weekStatus: '',
		dayNames: ['Söndag','Måndag','Tisdag','Onsdag','Torsdag','Fredag','Lördag'],
		dayNamesShort: ['Sön','Mån','Tis','Ons','Tor','Fre','Lör'],
		dayNamesMin: ['Sö','Må','Ti','On','To','Fr','Lö'],
		dayStatus: 'DD', dateStatus: 'D, M d',
        dateFormat: 'yy-mm-dd', firstDay: 1,
		initStatus: '', isRTL: false,
		showMonthAfterYear: false, yearSuffix: ''};
    $.datepick.setDefaults($.datepick.regional['sv']);
})(jWPDev);
