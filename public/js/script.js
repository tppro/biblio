function toggleResumee(id, deplie)
{
    let val_resumeestyle;
    let val_resumeedetailstyle;
    if (deplie) {
        val_resumeestyle = 'none';
        val_resumeedetailstyle = 'block';
    } else {
        val_resumeestyle = 'block';
        val_resumeedetailstyle = 'none';
    }
    
    document.getElementById('resumee_' + id).style.display = val_resumeestyle;
    document.getElementById('resumee_detail_' + id).style.display = val_resumeedetailstyle;
}

function createToggleElementsEvents(elements, val)
{
    elements.forEach(element => {
        element.addEventListener("click", function(event) {
            toggleResumee(this.getAttribute("rel"), val);
        });
    });
}

const resumee = document.querySelectorAll(".resumee");
createToggleElementsEvents(resumee, true);
const resumee_detail = document.querySelectorAll(".resumee_detail");
createToggleElementsEvents(resumee_detail, false);

async function getCountries()
{
    let response = await fetch("/api");
    let countries = await response.json();
    console.log(countries);
}
