(function(){
    ///DECLARATIONS///
    const monNameOb = document.getElementById("monName");
    const primaryTypeOb = document.getElementById("primaryType");
    const secondaryTypeOb = document.getElementById("secondaryType");
    const bioOb = document.getElementById("bio");

    const originialMonName = monNameOb.value;
    const originialPrimaryType = primaryTypeOb.value;
    const originialSecondaryType = secondaryTypeOb.value;
    const originialBio = bioOb.value;

    ///BUTTON EVENTS///
    const getMonButtons = document.getElementsByClassName('getMonBTN');
    for (let x = 0; x < getMonButtons.length; x++){
        getMonButtons[x].addEventListener("click", (e)=>{
            if (FoundChanges()){
                if (!confirm("You havn't saved changes. Proceed anyway?")){
                    e.preventDefault();
                }
            }
        }, false);
    }

    const orderButtons = document.getElementsByClassName('orderBTN');
    for (let x = 0; x < orderButtons.length; x++){
        orderButtons[x].addEventListener("click", (e)=>{
            if (FoundChanges()){
                if (!confirm("You havn't saved changes. Proceed anyway?")){
                    e.preventDefault();
                }
            }
        }, false);
    }

    const amendMonButon = document.getElementById('amendMonBTN');
    amendMonButon.addEventListener("click", (e)=>{
        if (!confirm("Are you sure you want to save these changes?")){
            e.preventDefault();
        }
    }, false);

    ///METHODS///
    const FoundChanges = ()=>{
        return monNameOb.value != originialMonName || bioOb.value != originialBio ||
        primaryTypeOb.value != originialPrimaryType || secondaryTypeOb.value != originialSecondaryType;
    }
})();