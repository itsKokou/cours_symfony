import Swal from 'sweetalert2';

function getData(select) {
    select.addEventListener("change",function(event){
        const option=event.target.options[select.selectedIndex];
        const path=option.getAttribute('data-path')
        fetch(path,{
            method: 'GET',
            headers: {
            'Content-Type': 'application/json'
            }
            }).then(response => response.json())
            .then(promesse => {
                window.location.href=promesse;
            })
            .catch(err => console.log(err))
    })
}