class Popup {
    static success(msg) {
    alertify.set({ delay: 5000 }); 
    alertify.success(msg); 
        /*const success= `<div class="col-sm-12"><div class="alert fade alert-simple alert-success alert-dismissible text-left font__family-montserrat font__size-16 font__weight-light brk-library-rendered rendered show"><button type="button" class="close font__size-18" data-dismiss="alert"><span aria-hidden="true"><a><i class="fa fa-times greencross"></i></a></span><span class="sr-only">Close</span></button><i class="start-icon far fa-check-circle faa-tada animated"></i>${msg}</div></div>`;

        const info = `<div class="col-sm-12"><div class="alert fade alert-simple alert-info alert-dismissible text-left font__family-montserrat font__size-16 font__weight-light brk-library-rendered rendered show" role="alert" data-brk-library="component__alert"><button type="button" class="close font__size-18" data-dismiss="alert"><span aria-hidden="true"><i class="fa fa-times blue-cross"></i></span><span class="sr-only">Close</span></button><i class="start-icon  fa fa-info-circle faa-shake animated"></i>${msg}</div></div>`;

        const warning = `<div class="col-sm-12">
        <div class="alert fade alert-simple alert-warning alert-dismissible text-left font__family-montserrat font__size-16 font__weight-light brk-library-rendered rendered show" role="alert" data-brk-library="component__alert">
          <button type="button" class="close font__size-18" data-dismiss="alert">
									<span aria-hidden="true">
										<i class="fa fa-times warning"></i>
									</span>
									<span class="sr-only">Close</span>
								</button>
          <i class="start-icon fa fa-exclamation-triangle faa-flash animated"></i>${msg}</div></div>`;

        const error = `<div class="col-sm-12">
        <div class="alert fade alert-simple alert-danger alert-dismissible text-left font__family-montserrat font__size-16 font__weight-light brk-library-rendered rendered show" role="alert" data-brk-library="component__alert">
          <button type="button" class="close font__size-18" data-dismiss="alert">
									<span aria-hidden="true">
										<i class="fa fa-times danger "></i>
									</span>
									<span class="sr-only">Close</span>
								</button>
          <i class="start-icon far fa-times-circle faa-pulse animated"></i>${msg}</div></div>`;

          switch(type){
                case 0:
                case 'success':
                    document.body.innerHTML+=success;
                    break;
                case 1:
                case 'info':
                    document.body.innerHTML+=info;
                    break;
                case 2:
                case 'warning':
                    document.body.innerHTML+=warning;
                    break;
                case 3:
                case 'error':
                    document.body.innerHTML+=error;
                    break;
          }*/
    }

    static error(msg) {
        alertify.set({ delay: 5000 }); 
        alertify.error(msg); 
    }

    static show(msg) {
        if (msg.indexOf('[Error]')>-1) {
            this.error(msg);
            return;
        }
        this.success(msg);
    }
}