<h3 class="page-title"> Справка
    <small></small>
</h3>
<div class="row">
    <div class="col-md-10">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <i class="icon-question font-dark"></i>
                    <span class="caption-subject bold uppercase"> Вставки в лендинг</span>
                </div>
                <div class="actions">
                    <div class="btn-group btn-group-devided">
                        <!--                        <button type="submit" class="btn green btn-outline">-->
                        <!--                            <i class="fa fa-save"></i> Save-->
                        <!--                        </button>-->
                    </div>
                </div>
            </div>
            <div class="portlet-body">
                <h3>
                    Вставка в тег HEAD <small>в самый конец, после подкоючения jQuery</small>
                </h3>
                <pre>
&lt;script>(function() {
    var _fbq = window._fbq || (window._fbq = []);
    if (!_fbq.loaded) {
        var fbds = document.createElement('script');
        fbds.async = true;
        fbds.src = '//connect.facebook.net/en_US/fbds.js';
        var s = document.getElementsByTagName('script')[0];
        s.parentNode.insertBefore(fbds, s);
        _fbq.loaded = true;
    }
    _fbq.push(['addPixelId', '&lt;?php echo $_GET['pixel']; ?>']);
})();
window._fbq = window._fbq || [];
window._fbq.push(['track', 'PixelInitialized', {}]);
&lt;/script>
&lt;noscript>&lt;img height="1" width="1" alt="" style="display:none" src="https://www.facebook.com/tr?id=&lt;?php echo $_GET['pixel']; ?>&amp;ev=PixelInitialized" />&lt;/noscript>
&lt;script src="&lt;?php echo SITE_DIR; ?>js/frontend/script.js">&lt;/script>
                </pre>
                <hr>
                <h3>Вставка в начало тега BODY</h3>
                <pre>
&lt;script src="http://cspm1.ru/js/m1ref.js">&lt;/script>
&lt;script type="text/javascript">
    var m1_product_id = '&lt;?php echo $product['affiliate_id']; ?>';
    var ref = '&lt;?php echo $product['webmaster_id']; ?>';
    var script = document.createElement("script");
    script.src = "http://m1-shop.ru/send_order/?ref="+ref+"&s="+getC("s")+"&w="+getC("w")+"&t="+getC("t")+"&product_id="+m1_product_id+'&out=1';
    document.body.appendChild(script);
&lt;/script>
                </pre>
                <h3>Особенности формы заказа</h3>
                <ul>
                    <li>Поле Имя должно иметь аттрибут name="name"</li>
                    <li>Поле Телефон должно иметь аттрибут name="phone"</li>
                    <li>Тег FORM должен иметь action="" и method="post"</li>
                    <li>Фотма должна содержать следующие скрытые поля:</li>
                </ul>
                <pre>
&lt;input type="hidden" name="product_id" value="&lt;?php echo $product['affiliate_id']; ?>"/>
&lt;input type="hidden" name="ref" value="&lt;?php echo $product['webmaster_id']; ?>"/>
&lt;input type="hidden" name="app_product_id" value="&lt;?php echo $product['id']; ?>"/>
                </pre>
                <h4>Пирмер формы</h4>
                <pre>
&lt;form action="" method="post">
    &lt;div class="price">
        &lt;p>
            &lt;span class="old medium">13300р.&lt;/span>
            &lt;span class="new yellow medium">3990р.&lt;/span>
        &lt;/p>
    &lt;/div>
    &lt;div>&lt;input name="name" type="text" placeholder="Введите ваше имя">&lt;/div>
    &lt;div>&lt;input name="phone" type="text" placeholder="Введите ваш телефон">&lt;/div>
    &lt;input type="hidden" name="product_id" value="&lt;?php echo $product['affiliate_id']; ?>"/>
    &lt;input type="hidden" name="ref" value="&lt;?php echo $product['webmaster_id']; ?>"/>
    &lt;input type="hidden" name="app_product_id" value="&lt;?php echo $product['id']; ?>"/>
    &lt;div>&lt;button>&lt;/button>&lt;/div>
&lt;/form>
                </pre>
            </div>
        </div>
    </div>
</div>