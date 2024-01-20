

function initSlider() {
    let transition = 800;//a modifier en meme temps que le css
    let defilement = 4000;//temps de defilement entre chaque image 
    currentImg === "init" ? currentImg = 0 : ""

    console.log("initialisation du slider");
    console.dir(sliderCat);
    //ici je récupere l'url de l'image à afficher dans mon slider
    console.dir(sliderCat[currentImg].url);
    const slider = document.querySelector("#slider");
    // creation d'une première image imageA
    const imageA = document.createElement("img");
    imageA.id = "imageA";
    imageA.src = sliderCat[currentImg].url;
    imageA.alt = sliderCat[currentImg].text1;
    imageA.style.zIndex = "2";
    slider.append(imageA);
    // creation d'une deuxieme image sous imageA
    const imageB = document.createElement("img");
    imageB.id = "imageB";
    imageB.src = "";
    imageB.alt = "";
    imageB.style.zIndex = "0";
    slider.append(imageB);
    // creation d'une balise p texteA
    const texteA = document.createElement("p");
    texteA.id = "texteA";

    //texteA.innerText = sliderCat[currentImg].text1+"/"+sliderCat[currentImg].text1;
    texteA.innerHTML = "<p class='text1'>" + sliderCat[currentImg].text1 + "</p><p class='text2'>"
        + sliderCat[currentImg].text2 + "</p>";
    texteA.style.zIndex = "3";
    slider.append(texteA);
    // creation d'une balise p texteB
    const texteB = document.createElement("p");
    texteB.id = "texteB";
    texteB.innerHTML = "";
    texteB.style.zIndex = "1";
    slider.append(texteB);
    // j'aimerai connaitre le height de mon imageA mais je doit 
    // d'abord attendre que cette image soit uploader par mon navigateur
    // je dois temporiser avec javascript avant d'obtenir les informations
    // de mon image
    setTimeout(() => {
        console.dir(imageA.clientHeight);
        slider.style.height = imageA.clientHeight + "px";
    }, transition);
    let trackB = currentImg + 1;
    imageB.src = sliderCat[trackB].url;
    imageB.alt = sliderCat[trackB].text2;
    texteB.innerHTML = "<p class='text1'>" + sliderCat[trackB].text1 + "</p><p class='text2'>"
        + sliderCat[trackB].text2 + "</p>";
    //effect : swipeLeft swipeRight swipeUp swipeDown fadeOut : string intégrés à slider.css
    let effect = "swipeRight"
    setInterval(() => {
        if (currentImg === sliderCat.length - 1) {
            currentImg = 0
        } else {
            currentImg++;
        }
        //ajouter ma transition
        imageA.classList.add("trans");
        texteA.classList.add("trans");
        imageA.classList.add(effect);
        texteA.classList.add(effect);
        setTimeout(() => {


            //je commence par incrémenter track
            if (trackB === sliderCat.length - 1) {
                trackB = 0;
            } else {
                trackB++;
            }

            console.log(currentImg)
            console.log(trackB)
            imageA.src = sliderCat[currentImg].url;
            imageA.alt = sliderCat[currentImg].text2;
            texteA.innerHTML = "<p class='text1'>" + sliderCat[currentImg].text1 + "</p><p class='text2'>"
                + sliderCat[currentImg].text2 + "</p>";
            //je dois retirer la transition
            imageA.classList.remove("trans");
            texteA.classList.remove("trans");
            imageA.classList.remove(effect);
            texteA.classList.remove(effect);
            imageB.src = sliderCat[trackB].url;
            imageB.alt = sliderCat[trackB].text2;
            texteB.innerHTML = "<p class='text1'>" + sliderCat[trackB].text1 + "</p><p class='text2'>"
                + sliderCat[trackB].text2 + "</p>";

        }, transition);
    }, defilement);
}

export { initSlider }