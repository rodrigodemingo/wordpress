/**
 * Javascript for processing the WpPrintPdf Button
 * to print the current page as a pdf
 *
 * To use this, you must mark the page / sections that will be
 * printed using data-printpdf="target", if no target found
 * it will go to body as the target
 *                 
 *  @author jason.xie@victheme.com
 */


(function($) {

  if (!window.VT) {
    window.VT = {};
  }

  window.VT.printPDF = function(filename, content) {
    var doc = new jsPDF('p', 'pt'),
        $content = $(content),
        res = doc.autoTableHtmlToJson($content.find('table')[0]),
        image = $content.find('img'),
        header = $content.find('#header'),
        yPos = 20;

    // Inject table at the end, this is sucks, we need to find a way
    // to inject as fromHTML is parsing and use the autoTables to style it.
    $content.find('table, img, #header').remove();
    doc.setFont('helvetica');

    if (header.length) {
      doc.fromHTML(header.html(), 20, yPos, {
          'width': 540
        },
        function(dispose) {
          yPos = yPos + dispose.y;

          // Draw Lines
          doc.setDrawColor(41,128,186);
          doc.setLineWidth(1);
          doc.line(20, yPos - 20, 570, yPos - 20);
        });
    }

    if (image.length && image.attr('src')) {
      try {
        doc.addImage(image.attr('src'), 20, yPos, 550, 220);
        yPos = yPos + 240;
      }
      catch(e) {

      }
    }

    doc.fromHTML($content.html(), 20, yPos, {
      'width': 540
    },

    // End parsing
    function(dispose) {
      doc.autoTable(res.columns, res.data, {
        margin: {
          left: 20,
          right: 20,
          bottom: 20,
          top: 20
        },
        startY: 20 + dispose.y
      });
      doc.save(filename + '.pdf');
    });
  }

  $(document)
    .on('ajaxComplete.wp-pdf', function(event, xhr, settings) {
      // Support for wp-pdf only.
      if (settings.marker && settings.marker == 'wp-pdf') {
        var AjaxData = $.fn.VTCoreProcessAjaxResponse(xhr.responseText);
        AjaxData.content
          && AjaxData.content.action
          && $.each(AjaxData.content.action, function (key, data) {
          if (data.mode && data.mode == 'wppdf-generate' && data.filename && data.content) {
            VT.printPDF(data.filename, data.content.replace(/(\r\n|\n|\r)/gm, ""));
          }
        });
      }
    });

})(jQuery);