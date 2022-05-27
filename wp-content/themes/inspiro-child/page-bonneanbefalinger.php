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
 * @version 1.0.0
 */

get_header(); 
?>

   <template>
      <article class="styleanbefalinger">
        <img src="" alt="" />
        <h2></h2>
        <p class="tekst"></p>
      </article>
    </template>

	<div id="primary" class="content-area">
                
 
    
		<main id="main" class="site-main">	
      <nav id="filtrering">
      </nav>
      <h1></h1>
            <section class="anbefalingcontainer"></section>
    </main><!-- #main -->

<script>
    "use strict";
       console.log("nu starter script");
      const container = document.querySelector(".anbefalingcontainer");
      const temp = document.querySelector("template");

      const url = "https://mathildese.dk/kea/10_eksamen/wp-json/wp/v2/anbefaling?per_page=100";
      const catUrl = "https://mathildese.dk/kea/10_eksamen/wp-json/wp/v2/categories";

      let data = [];
      let categories; 
      let filterAnbefaling = "alle";

      let filter = "alle";
      const filterknapper = document.querySelectorAll("button");
      let anbefalinger;
    

      document.addEventListener("DOMContentLoaded", start);

      function start() {
        filterknapper.forEach((knap) => {
          knap.addEventListener("click", setFilter);
        });

        hentData();
      }

      function setFilter() {
        filter = this.dataset.anbefaling;
        document.querySelector("h1").textContent = this.textContent;
        vis();
      }

      async function hentData() {
        // console.log("hentData");
        const respons = await fetch(url);
        const catData = await fetch(catUrl);
        anbefalinger = await respons.json();
        categories = await catData.json();
        console.log(categories);
        vis();
        opretKnapper();
      }

      function opretKnapper() {

        categories.forEach(cat =>{
          document.querySelector("#filtrering").innerHTML += `<button class="filter" data-anbefaling="${cat.id}">${cat.name}</button>`
        })

        addEventListenersToButtons();
      }

      function addEventListenersToButtons(){
          document.querySelectorAll("#filtrering button").forEach(elm => {
            elm.addEventListener("click", filtrering);
          })

      };

      function filtrering() {
           filterAnbefaling = this.dataset.anbefaling;
           console.log(filterAnbefaling);

           vis();
      }

      function vis() {
        console.log("vis");
        console.log(anbefalinger);
        container.textContent = "";

        anbefalinger.forEach((anbefaling) => {
          const klon = temp.cloneNode(true).content;

          //FILTRERING
          if (filterAnbefaling == "alle" || anbefaling.categories.includes(parseInt(filterAnbefaling))) {
            klon.querySelector(".tekst").textContent =anbefaling.tekst;
            klon.querySelector("h2").textContent =anbefaling.title.rendered;
            klon.querySelector("img").src = anbefaling.billede.guid;
            klon.querySelector("article").addEventListener("click", () => {location.href = anbefaling.link; })
            container.appendChild(klon);
               }
          })
      }

     /* function visDetaljer (hvad) {
        location.href = `page-boenne-detalje.php?id=${hvad._id}`;}
        */

    </script>

<?php
get_footer();
