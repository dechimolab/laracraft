/**
 * Datepicker initialization for MA BUCC
 * Supports Thai Buddhist calendar (ปี พ.ศ. = ค.ศ. + 543)
 */
$(function() {
    initDatePicker();
});

function initDatePicker() {
    if (typeof $.fn.datepicker === 'undefined') return;

    var d = new Date();

    $('.datepicker').each(function() {
        var $input = $(this);
        if ($input.hasClass('hasDatepicker')) {
            return;
        }

        $input.datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: 'dd/mm/yy',
            isBuddhist: true, // true = ปี พ.ศ.
            defaultDate: d,
            yearRange: 'c-60:c+20',
            dayNames: ['อาทิตย์', 'จันทร์', 'อังคาร', 'พุธ', 'พฤหัสบดี', 'ศุกร์', 'เสาร์'],
            dayNamesMin: ['อา.', 'จ.', 'อ.', 'พ.', 'พฤ.', 'ศ.', 'ส.'],
            monthNames: ['มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'],
            monthNamesShort: ['ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.', 'ต.ค.', 'พ.ย.', 'ธ.ค.'],
            nextText: "ถัดไป",
            prevText: "ก่อนหน้า",
            currentText: "วันนี้",
            closeText: "ปิด",
            showButtonPanel: true,
            beforeShow: function(input) {
                setTimeout(function() {
                    var $inst = $(input);
                    var $buttonPane = $inst.datepicker("widget").find(".ui-datepicker-buttonpane");
                    $buttonPane.find(".ui-datepicker-clean").remove();
                    $("<button type='button' class='ui-datepicker-clean'>ล้างค่า</button>")
                        .appendTo($buttonPane)
                        .click(function() {
                            $inst.val("");
                            $inst.datepicker("hide");
                        });
                }, 1);
            },
            onChangeMonthYear: function(yy, mm, inst) {
                setTimeout(function() {
                    var $inst = $(inst.input);
                    var $buttonPane = $inst.datepicker("widget").find(".ui-datepicker-buttonpane");
                    $buttonPane.find(".ui-datepicker-clean").remove();
                    $("<button type='button' class='ui-datepicker-clean'>ล้างค่า</button>")
                        .appendTo($buttonPane)
                        .click(function() {
                            $inst.val("");
                            $inst.datepicker("hide");
                        });
                }, 1);
            }
        });
    });
}
