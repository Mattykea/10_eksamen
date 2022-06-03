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
        <h1 class="bonne_h1">BØNNEANBEFALINGER</h1>
        <p class="bonne_p">True Intent Coffee hjælper dig til at finde de bedste kaffebønner, der passer bedst til dine kaffebehov. Vi har bønner med en rund chokolade aroma og bønner med et citrus finish så der er noget til enhver smag.</p>

        <section class="section1">

          <div class="col1">
            <h2>Filterkaffe</h2>
            <img class="filterbil" src="" alt="">
            <p>Filterkaffen er den slags kaffe, du brygger på din kaffemaskine. I maskinen drysser du din kaffe i filteret, hvor vandet løber igennem for at brygge den perfekte kop kærlighed. Her ender du med en traditionel sort kaffe, hvor der kan tilføjes mælk eller sukker. Hvis du kunne tænke dig at prøve filterkaffe så tryk på knappen nedenfor.</p>          
          </div>

          <div class="col2">
            <h2>Espresso</h2>
            <img class="espressobil" src="" alt="">
            <p>Espresso refererer til en bryggemetode, så espresso er en specifik måde at lave kaffe på. Espresso er brygget under intenst tryk og er en lille og koncentreret kop kaffe. Hvis du leder efter de perfekte bønner, at brygge espresso på så tryk på knappen nedenfor.</p>          
          </div>   
        </section>

        <nav id="filtrering"></nav>

        <!-- Der vores json/pods indhold ligger -->
        <section id="anbefaling-test"
        class="anbefalingcontainer"></section>
      </main><!-- #main -->

      <template>
        <article class="styleanbefalinger">
          <img src="" alt="" />
          <h2></h2>
          <p class="tekst"></p>
        </article>
      </template>

    </div><!-- #primary -->


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
        console.log("hentData");
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
            klon.querySelector("img").src = anbefaling.billede.guid;
            klon.querySelector("h2").textContent = anbefaling.title.rendered;
            console.log("Hej " + anbefaling.link)
            klon.querySelector("article").addEventListener("click", () => {location.href = anbefaling.link; })
            container.appendChild(klon);
               }
          })
      }
       
    </script>

    	

<?php
get_footer();
