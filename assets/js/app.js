//Show hide vendeur form
function showHideForm(){
    let vendeurForm = document.getElementById("formulaire-vendeur");
    if(vendeurForm.style.display === "none"){
        vendeurForm.style.display = "block";
    }else {
        vendeurForm.style.display = "none";
    }
}