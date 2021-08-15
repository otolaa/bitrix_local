<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
//
if(!empty($arResult['ITEMS'])): ?>
<div id="<?=$arResult['DIV']?>" class="map-wrap"
     style="height: <?=$arResult['HEIGHT']."px"?>; width: 100%; margin: 20px auto;">
</div>
<script type="text/javascript">
    $(document).ready(function(){
        ymaps.ready(initialize);
        function initialize() {
            var myMap = new ymaps.Map('<?="mapCamp"?>', {
                center:[55.762996, 37.432978], // Москва
                zoom: 16,
                controls: ['typeSelector', 'fullscreenControl']
            });
            myMap.controls.add('zoomControl', {size: "small", position: {right: '10px', top: '100px'}});
            var myClusterer = new ymaps.Clusterer({preset:'<?=$arParams['CLUSTERER']?>'});
            var myGeoObjects = [];
            var obj =  <?=json_encode($arResult['ITEMS'])?>;
            $.each(obj,function(i) {
                /**/
                var latlng = this.COORDINATES.split(',');
                myGeoObjects[i] = new ymaps.Placemark(
                    [latlng[0], latlng[1]],
                    {balloonContentHeader:this.title, balloonContent: this.description},
                    {preset: "<?=$arParams['PRESET']?>",iconColor: '<?=$arParams['ICON_COLOR']?>'});
            }); /* -- end Creating markers */

            /* https://tech.yandex.ru/maps/doc/jsapi/2.0/ref/reference/Map-docpage/#setBounds-param-options */
            myClusterer.add(myGeoObjects);
            myMap.geoObjects.add(myClusterer);
            myMap.setBounds(myClusterer.getBounds(),{
                checkZoomRange:true,
                zoomMargin:20
            });
        }
    });
</script>
<? endif; ?>