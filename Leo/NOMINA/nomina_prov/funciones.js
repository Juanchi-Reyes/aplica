function limpiar(){
    document.form.reset();
    document.form.cod.focus();
}
function validar(){
    var form = document.form;
    if(form.cod.value==0){
        Swal.fire({
        icon : 'error',
        title : 'ERROR!!',
        text :  'Debe digitar el codigo'
        });
        form.cod.value="";
        form.cod.focus();
        return false;
    }
    if(form.nom.value==0){
        Swal.fire({
        icon : 'error',
        title : 'ERROR!!',
        text :  'Debe digitar el Nombre'
        });
        form.nom.value="";
        form.nom.focus();
        return false;
    }
    if(form.ape.value==0){
        Swal.fire({
        icon : 'error',
        title : 'ERROR!!',
        text :  'Debe digitar el apellido'
        });
        form.ape.value="";
        form.ape.focus();
        return false;
    }
    if(form.em.value==0){
        Swal.fire({
        icon : 'error',
        title : 'ERROR!!',
        text :  'Debe digitar el email'
        });
        form.em.value="";
        form.em.focus();
        return false;
    }
    if(form.tel.value==0){
        Swal.fire({
        icon : 'error',
        title : 'ERROR!!',
        text :  'Debe digitar el Telfono'
        });
        form.tel.value="";
        form.tel.focus();
        return false;
    }
    if(form.fn.value==0){
        Swal.fire({
        icon : 'error',
        title : 'ERROR!!',
        text :  'Debe digitar la Fecha'
        });
        form.fn.value="";
        form.fn.focus();
        return false;
    }
    form.submit();
}
