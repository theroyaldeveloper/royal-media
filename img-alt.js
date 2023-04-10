jQuery(document).ready(($)=>{
	'use strict';

  $('img').each(function () {
    if (!$(this).attr('alt')) {
      const title = $(this).attr('title');
      if (title) {
        $(this).attr('alt', title);
      }
    }
  });
});