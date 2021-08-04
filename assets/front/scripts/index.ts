import {toggleForm} from "./Form/toggleSearch";

window.onscroll = function() {
    let d = document.documentElement;
    let offset = d.scrollTop + window.innerHeight;
    let height = d.offsetHeight;
    if (offset >= height) {
        console.log('At the bottom');
    }
};

function fetchData()
{
    fetch('/test-ajax')
        .then(result => result.json())
        .then((data) => {

        });
}

toggleForm();