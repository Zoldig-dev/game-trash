export function toggleForm() {
    if(location.pathname === '/games') {
        let btnToggleElement = document.querySelector('.toggle-form');
        let form: HTMLFormElement = document.querySelector('.toggleable');
        btnToggleElement.addEventListener('click', (e) => {
            if(!form.style.maxHeight || form.style.maxHeight === '0px') {
                btnToggleElement.classList.add('open');
                form.style.maxHeight = form.scrollHeight + 'px';
                form.style.opacity = '1'
            } else {
                btnToggleElement.classList.remove('open');
                form.style.maxHeight = '0px';
                form.style.opacity = '0'
            }
        })
    }
}