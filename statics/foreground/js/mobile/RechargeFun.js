$(function() {


    var d = 10;
    var g = false;
    var a = null;
    var f = null;
    var b = null;
    var c = 1;
	var banktype='CMBCHINA-WAP';

    //微信客户端特殊处理
    banktype =  bindWX();

    var e = function() {
        var k = function(p, o, n, m) {
            $.PageDialog.fail(p, o, n, m)
        };
        function l(m) {
            m = Math.round(m * 1000) / 1000;
            m = Math.round(m * 100) / 100;
            if (/^\d+$/.test(m)) {
                return m + ".00"
            }
            if (/^\d+\.\d$/.test(m)) {
                return m + "0"
            }
            return m
        }
        var h = /^[1-9]{1}\d*$/;
        var j = "";
        var i = function() {
            var m = a.val();
            if (m != "") {
                if (j != m) {
                    if (!h.test(m)) {
                        a.val(j).focus()
                    } else {
                        j = m;
                        //f.html('选择平台充值<em class="orange">' + l(m) + "</em>元")
                    }
                }
            } else {
                j = "";
                a.focus();
               // f.html('选择平台充值<em class="orange">0.00</em>元')
            }
        };
        $("#ulOption > li").each(function(m) {
            var n = $(this);
            if (m < 7) {
                n.click(function() {
                    g = false;
                    d = n.attr("money");
                    n.children("a").addClass("z-sel");
                    n.siblings().children('a').removeClass("z-sel").removeClass("z-initsel");
                    $("#ulOption > li").find('b').removeClass("z-initsel");
                    f.html('选择平台充值<em class="orange">' + n.attr("money") + ".00</em>元")
                })
            } else {
                a = n.find("input");
                a.focus(function() {
                    g = true;
                    if (a.val() == "输入金额") {
                        a.val("")
                    }
                    a.parent().addClass("z-initsel").parent().siblings().children().removeClass("z-sel");
                    if (b == null) {
                        b = setInterval(i, 200)
                    }
                }).blur(function() {
                    clearInterval(b);
                    b = null
                })
            }
        });
        $("#ulBankList > li").each(function(m) {

            var n = $(this);   		
			if (m == 0) {			
                f = n
            } else {
                n.click(function() {				 
                    c = m;
					banktype=n.attr('urm');	
                    n.children("i").attr("class", "z-bank-Roundsel");
                    n.siblings().children("i").attr("class", "z-bank-Round")
                })
            }
        });
        $("#btnSubmit").click(function() {
            d = g ? a.val() : d;
            if (d == "" || parseInt(d) == 0) {
                k("请输入充值金额")
            } else {
                var m = /^[1-9]\d*\.?\d{0,2}$/;
                if (m.test(d)) {
                    //if (c == 1 || c==2 ||c==3||c==4 ||c==5) {
                    if (banktype == 2) {			//银联支付
                        //console.log(c+'>'+d+'>'+banktype+'银联');return false;
                        location.href = Gobal.Webpath+"/cart/addmoney/" + d+"/"+banktype
                    }else{					//微信支付
                    	//console.log(c+'>'+d+'>'+banktype+'微信');return false;
                    	//location.href = Gobal.Webpath+"/pay/jspay?money=" + d;
                    	location.href = Gobal.Webpath+"/cart/addmoney/" + d+"/"+banktype
                    }
                } else {
                    k("充值金额输入有误")
                }
            }
        })
    };
    Base.getScript(Gobal.Skin + "/js/mobile/pageDialog.js", e)
});

function bindWX() {
    
    var booktype = 'CMBCHINA-WAP';
    var u = navigator.userAgent;
    if (u.indexOf('MicroMessenger') > -1) //微信浏览器
    {
        $('#ulBankList').empty();
        var _html = '<li class="gray6">选择平台充值<em class="orange">10.00</em>元</li>';
        //_html += '<li class="gray9" urm="1"><i class="z-bank-Roundsel"><s></s></i>微信支付微信端</li>';
        _html += '<li class="gray9" urm="2"><i class="z-bank-Roundsel"><s></s></i>银联支付</li>';

        $('#ulBankList').append(_html);
        booktype = 1;
    }else{
        $('#ulBankList').empty();
        var _html = '<li class="gray6">选择平台充值<em class="orange">10.00</em>元</li>';
        _html += '<li class="gray9" urm="9"><i class="z-bank-Roundsel"><s></s></i>银联支付</li>';

        $('#ulBankList').append(_html);
        booktype = 2;    	
    }
    
    //booktype = 9;
   return booktype;
}
																																																																
 