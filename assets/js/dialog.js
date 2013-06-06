/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

var posting_url = '';

$(".posting").click(function() {
    posting_url = $(this).attr('href');
    fancyConfirm('Anda yakin akan memposting data ini?', posting_confirm);
    return false;
});

function posting_confirm(result) {
    if (result) {
        window.location.href = posting_url;
    }
}

function fancyAlert(msg) {
    jQuery.fancybox({
        'modal': true,
        'content': "<div style=\"margin:1px;width:240px;\">" + msg + "<div style=\"text-align:right;margin-top:10px;\"><input style=\"margin:3px;padding:0px;\" type=\"button\" onclick=\"jQuery.fancybox.close();\" value=\"Ok\"></div></div>"
    });
}

function fancyConfirm(msg, callback) {
    var ret;
    jQuery.fancybox({
        modal: true,
        content: "<div style=\"margin:1px;width:240px;\">" + msg + "<div style=\"text-align:right;margin-top:10px;\"><input id=\"fancyConfirm_cancel\" style=\"margin:3px;padding:0px;\" type=\"button\" value=\"Batal\"><input id=\"fancyConfirm_ok\" style=\"margin:3px;padding:0px;\" type=\"button\" value=\"OK\"></div></div>",
        onComplete: function() {
            jQuery("#fancyConfirm_cancel").click(function() {
                ret = false;
                jQuery.fancybox.close();
            })
            jQuery("#fancyConfirm_ok").click(function() {
                ret = true;
                jQuery.fancybox.close();
            })
        },
        onClosed: function() {
            callback.call(this, ret);
        }
    });
}