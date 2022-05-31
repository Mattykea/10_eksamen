<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Inspiro
 * @subpackage Inspiro_Lite
 * @since Inspiro 1.0.0
 * @version 1.0.1
 */

get_header(); 
?>

	<div id="primary" class="content-area">

        <main id="main" class="site-main">	

            <template>
                <article class="styledetalje">
                    <img src="" alt="" />
                    <div class="right_col">
                      <h2></h2>
                      <p class="tekst"></p>
                    </div>
                </article>
            </template>

    
            <section class="anbefalingcontainer"></section>
        </main><!-- #main -->

<script>
       console.log("nu starter script");
      const container = document.querySelector(".anbefalingcontainer");
      const temp = document.querySelector("template");

      const url = "https://mathildese.dk/kea/10_eksamen/wp-json/wp/v2/anbefaling/"+<?php echo get_the_ID() ?>;

      let data = [];

      let filter = "alle";
      const filterknapper = document.querySelectorAll("button");
      let anbefaling;
    

      document.addEventListener("DOMContentLoaded", start);

      function start() {
        filterknapper.forEach((knap) => {
          knap.addEventListener("click", setFilter);
        });

        hentData();
      }

      function setFilter() {
        filter = this.dataset.kategori;
        document.querySelector("h1").textContent = this.textContent;
        vis();
      }

      async function hentData() {
        console.log("hentData");
        const respons = await fetch(url);
        anbefaling = await respons.json();
        vis();
      }
      
      function vis() {
        console.log("vis");
        console.log(anbefaling);
        container.textContent = "";

          const klon = temp.cloneNode(true).content;

         klon.querySelector(".tekst").textContent = anbefaling.tekst;
            klon.querySelector("h2").textContent = anbefaling.title.rendered;
            klon.querySelector("img").src = anbefaling.billede.guid;
            container.appendChild(klon);
      
      }

     hentData();
    </script>

	</div><!-- #primary -->

<?php
get_footer();
