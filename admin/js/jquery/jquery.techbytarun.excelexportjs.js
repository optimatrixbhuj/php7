/*
 * jQuery Client Side Excel Export Plugin Library
 * http://techbytarun.com/
 *
 * Copyright (c) 2013 Batta Tech Private Limited
 * https://github.com/tarunbatta/ExcelExportJs/blob/master/LICENSE.txt
 */

(function ($) {
    var $defaults = {
        containerid: null
        , datatype: 'table'
        , dataset: null
        , columns: null
        , returnUri: false
        , worksheetName: "My Worksheet"
        , encoding: "utf-8"
		, ignoreColumn: []
		, ignoreClass: null
		, fileName: "Export"
		, fileExt: ".xls"
    };

    var $settings = $defaults;

    $.fn.excelexportjs = function (options) {
        $settings = $.extend({}, $defaults, options);

        var gridData = [];
        var excelData;

        return Initialize();

        function Initialize() {
            var type = $settings.datatype.toLowerCase();

            BuildDataStructure(type);

            switch (type) {
                case 'table':
                    excelData = Export(ConvertFromTable());
                    break;
                case 'json':
                    excelData = Export(ConvertDataStructureToTable());
                    break;
                case 'xml':
                    excelData = Export(ConvertDataStructureToTable());
                    break;
                case 'jqgrid':
                    excelData = Export(ConvertDataStructureToTable());
                    break;
            }

            if ($settings.returnUri) {
                return excelData;
            }
            else {
               // window.open(excelData);
			   a = document.createElement("a");
                a.download = $settings.fileName+$settings.fileExt;
                a.href = excelData;

                document.body.appendChild(a);

                a.click();

                document.body.removeChild(a);
            }
        }

        function BuildDataStructure(type) {
            switch (type) {
                case 'table':
                    break;
                case 'json':
                    gridData = $settings.dataset;
                    break;
                case 'xml':
                    $($settings.dataset).find("row").each(function (key, value) {
                        var item = {};

                        if (this.attributes != null && this.attributes.length > 0) {
                            $(this.attributes).each(function () {
                                item[this.name] = this.value;
                            });

                            gridData.push(item);
                        }
                    });
                    break;
                case 'jqgrid':
                    $($settings.dataset).find("rows > row").each(function (key, value) {
                        var item = {};

                        if (this.children != null && this.children.length > 0) {
                            $(this.children).each(function () {
                                item[this.tagName] = $(this).text();
                            });

                            gridData.push(item);
                        }
                    });
                    break;
            }
        }

        function ConvertFromTable() {
            //var result = $('<div>').append($('#' + $settings.containerid).clone()).html();
			var excel="<table>";
			// Header
			
			$('#' + $settings.containerid).find('thead').find('tr:visible').each(function() {
				excel += "<tr>";
				$(this).filter(':visible').find('th,td').each(function(index,data) {
					if(!$(this).hasClass($settings.ignoreClass)){
					if ($(this).css('display') != 'none'){					
						if($settings.ignoreColumn.indexOf(index) == -1){
							//excel += "<td>" + (($(this).clone()).html())+ "</td>";
							excel += $(this).clone().wrap('<p>').parent().html()
						}
					}
					}
				});	
				excel += '</tr>';						
				
			});					
			
			
			// Row Vs Column
			var rowCount=1;
			$('#' + $settings.containerid).find('tbody').find('tr:visible').each(function() {
				excel += "<tr>";
				var colCount=0;
				$(this).filter(':visible').find('td,th').each(function(index,data) {
					if(!$(this).hasClass($settings.ignoreClass)){
					if ($(this).css('display') != 'none'){	
						if($settings.ignoreColumn.indexOf(index) == -1){
							//console.log($(this).clone());
							//excel += "<td>"+(($(this).clone()).html())+"</td>";
							excel+=$(this).clone().wrap('<p>').parent().html();
						}
					}
					}
					colCount++;
				});																		
				rowCount++;
				excel += '</tr>';
			});			
			
			//Footer
			$('#' + $settings.containerid).find('tfoot').find('tr:visible').each(function() {
				excel += "<tr>";
				$(this).filter(':visible').find('th,td').each(function(index,data) {
					if(!$(this).hasClass($settings.ignoreClass)){
					if ($(this).css('display') != 'none'){					
						if($settings.ignoreColumn.indexOf(index) == -1){
							//excel += "<td>" + (($(this).clone()).html())+ "</td>";
							excel += $(this).clone().wrap('<p>').parent().html()
						}
					}
					}
				});	
				excel += '</tr>';						
				
			});			
			excel += '</table>';
			excel= excel.replace(/<A[^>]*>|<\/A>/gi, "");	//remove if u want links in your table
			excel= excel.replace(/<img[^>]*>/gi,""); 		//remove if u want images in your table
			excel= excel.replace(/<input[^>]*>|<\/input>/gi, ""); 	//reomves input params
            return excel;
        }

        function ConvertDataStructureToTable() {
            var result = "<table>";

            result += "<thead><tr>";
            $($settings.columns).each(function (key, value) {
                if (this.ishidden != true) {
                    result += "<th";
                    if (this.width != null) {
                        result += " style='width: " + this.width + "'";
                    }
                    result += ">";
                    result += this.headertext;
                    result += "</th>";
                }
            });
            result += "</tr></thead>";

            result += "<tbody>";
            $(gridData).each(function (key, value) {
                result += "<tr>";
                $($settings.columns).each(function (k, v) {
                    if (value.hasOwnProperty(this.datafield)) {
                        if (this.ishidden != true) {
                            result += "<td";
                            if (this.width != null) {
                                result += " style='width: " + this.width + "'";
                            }
                            result += ">";
                            result += value[this.datafield];
                            result += "</td>";
                        }
                    }
                });
                result += "</tr>";
            });
            result += "</tbody>";

            result += "</table>";
            return result;
        }

        function Export(htmltable) {
            var excelFile = "<html xmlns:o='urn:schemas-microsoft-com:office:office' xmlns:x='urn:schemas-microsoft-com:office:excel' xmlns='http://www.w3.org/TR/REC-html40'>";
            excelFile += "<head>";
            excelFile += '<meta http-equiv="Content-type" content="text/html;charset=' + $defaults.encoding + '" />';
            excelFile += "<!--[if gte mso 9]>";
            excelFile += "<xml>";
            excelFile += "<x:ExcelWorkbook>";
            excelFile += "<x:ExcelWorksheets>";
            excelFile += "<x:ExcelWorksheet>";
            excelFile += "<x:Name>";
            excelFile += "{worksheet}";
            excelFile += "</x:Name>";
            excelFile += "<x:WorksheetOptions>";
            excelFile += "<x:DisplayGridlines/>";
            excelFile += "</x:WorksheetOptions>";
            excelFile += "</x:ExcelWorksheet>";
            excelFile += "</x:ExcelWorksheets>";
            excelFile += "</x:ExcelWorkbook>";
            excelFile += "</xml>";
            excelFile += "<![endif]-->";
            excelFile += "</head>";
            excelFile += "<body>";
            excelFile += htmltable.replace(/"/g, '\'');
            excelFile += "</body>";
            excelFile += "</html>";

            var uri = "data:application/vnd.ms-excel;base64,";
            var ctx = { worksheet: $settings.worksheetName, table: htmltable };

            return (uri + base64(format(excelFile, ctx)));
        }

        function base64(s) {
            return window.btoa(unescape(encodeURIComponent(s)));			
        }

        function format(s, c) {
            return s.replace(/{(\w+)}/g, function (m, p) { return c[p]; });
        }
		
		
    };
})(jQuery);