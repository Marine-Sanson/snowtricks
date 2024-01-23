window.onload = () => {
    const buttonShow = document.querySelector("[data-toggle=show]");
    buttonShow.addEventListener("click", function(e){
        
        e.preventDefault();

        let target = this.dataset.target

        let deck = document.querySelector(target);
        deck.classList.remove("showComp");    
        deck.classList.remove("hideComp");    
        deck.classList.add("hideSmart");    
        deck.classList.add("showSmart");

        let btn = document.getElementById("buttonToggle");
        btn.classList.remove("hideComp");    
        btn.classList.remove("showSmart");    
        btn.classList.add("showComp");    
        btn.classList.add("hideSmart");

    });
}
