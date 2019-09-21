<?php get_header();?>

<!-- s-content
================================================== -->
<section class="s-content s-content--narrow">




    <div class="row">

        <div class="s-content__header col-full">
            <h1 class="s-content__header-title">
                Feel Free To Contact Us.
            </h1>
        </div> <!-- end s-content__header -->
        <?php while(have_rows('contact_content','option')):
        the_row(); ?>

        <div class="s-content__media col-full">
            <div id="map-wrap">
                <div id="map-container"></div>
                <div id="map-zoom-in"></div>
                <div id="map-zoom-out"></div>
                <?php //the_sub_field('contact_content_map');?>
            </div>
        </div> <!-- end s-content__media -->

        <!-- 1. Создаем элемент внутри которого у нас будет отображаться карта Google Maps -->
        <!-- 4. Пишем скрипт который создаст и отобразит карту Google Maps на странице. -->
        <script type="text/javascript">

            // Определяем переменную map
            var mapContainer;
            // Функция initMap которая отрисует карту на странице
            function initMap() {

                // В переменной map создаем объект карты GoogleMaps и вешаем эту переменную на <div id="map"></div>
                mapContainer = new google.maps.Map(document.getElementById('map-container'), {
                    // При создании объекта карты необходимо указать его свойства
                    // center - определяем точку на которой карта будет центрироваться
                    center: {lat: 46.4737746, lng: 30.7593235},
                    // zoom - определяет масштаб. 0 - видно всю платнеу. 18 - видно дома и улицы города.
                    zoom: 14
                });

                var marker = new google.maps.Marker({

                    // Определяем позицию маркера
                    position: {lat: 46.4738014, lng: 30.7592438},

                    // Указываем на какой карте он должен появится. (На странице ведь может быть больше одной карты)
                    map: mapContainer,

                    // Пишем название маркера - появится если навести на него курсор и немного подождать
                    title: 'Atomspace'
                });
            }

        </script>

    <!-- 3. Подключаем библиотеку Google Maps Api, чтобы создать карту -->
    <!-- Атрибуты async и defer - позволяют загружать этот скрипт асинхронно, вместе с загрузкой всей страницы  -->
    <!-- В подключении библиотеки Google Maps Api в конце указан параметр callback, после  подключения и загрузки этого Api сработает функция initMap для отрисовки карты,  которую мы описали выше -->

        <script async defer src="https://maps.googleapis.com/maps/api/js?callback=initMap"></script>

        <div class="col-full s-content__main">

                <p class="lead"><?php the_sub_field('contact_content_lead');?></p>
                <p><?php the_sub_field('contact_content_main');?></p>

            <?php endwhile;?>
            <div class="row">

            <?php while(have_rows('where_to_find_us','option')):
                the_row(); ?>
                    <div class="col-six tab-full">
                        <h3>Where to Find Us</h3>

                        <p>
                            <?php the_sub_field('contact_info_city');?><br>
                            <?php the_sub_field('contact_info_street');?><br>
                            <?php the_sub_field('contact_info_index');?>
                        </p>

                    </div>
            <?php endwhile;?>
            <?php while(have_rows('contact_info','option')):
                the_row(); ?>
                    <div class="col-six tab-full">
                        <h3>Contact Info</h3>

                        <p><?php the_sub_field('contact_info_email');?><br>
                            <?php the_sub_field('contact_info_phone');?><br>
                            <?php the_sub_field('contact_info_second_phone');?>
                        </p>

                    </div>

            <?php endwhile;?>
            </div> <!-- end row -->



            <h3>Say Hello.</h3>
            <?php echo do_shortcode("[contact-form-7 id=\"315\" title=\"Контактная форма 1\"]");?>

        </div> <!-- end s-content__main -->

    </div> <!-- end row -->

</section> <!-- s-content -->


<!-- s-extra
================================================== -->
<section class="s-extra">

    <?php get_template_part( 'footer-content', 'none' );?>

</section> <!-- end s-extra -->


<!-- s-footer
================================================== -->
<?php get_footer();?>