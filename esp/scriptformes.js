
    function ComprovarDades(FormContacte){
            var LblError = document.getElementById("LblError")
            TxtNom = document.getElementById("TxtNom")
            TxtTelefon = document.getElementById("TxtTelefon")
            TxtFax = document.getElementById("TxtFax")
            TxtEmail = document.getElementById("TxtEmail")
            LstDia = document.getElementById("LstDia")
            LstMes = document.getElementById("LstMes")
            LstAny = document.getElementById("LstAny")
            TxtHora = document.getElementById("TxtHora")
            LstMenu = document.getElementById("LstMenu")
            TxtCobertsAdults = document.getElementById("TxtCobertsAdults")
            TxtCobertsNens1014 = document.getElementById("TxtCobertsNens1014")
            TxtCobertsNens49 = document.getElementById("TxtCobertsNens49")
            TxtCotxets = document.getElementById("TxtCotxets")
            TxtObservacions = document.getElementById("TxtObservacions")
            if(TxtNom.value.search("[A-Za-z]") == -1){
                LblError.innerText = "Introduzca un nombre válido !"
                return
            }else{
                if(TxtTelefon.value.search("[0-9]{9}") == -1){
                    LblError.innerText = "Introduzca un número de teléfono válido !"
                    return
                }else{
                    if(TxtFax.value.length != 0 && TxtFax.value.search("[0-9]{9}") == -1){
                        LblError.innerText = "Introduzca un número fax válido !"
                        return
                    }else{
                        if(TxtEmail.value.length != 0 && TxtEmail.value.search("[A-Za-z0-9]+@[A-Za-z0-9]+") == -1){
                            LblError.innerText = "Introduzca un e-mail válido !"
                            return
                        }else{
                            if(LstDia.value == 0 || LstMes.value == 0 || LstAny.value == 0 || TxtHora.value.search("[0-9]+:[0-9]+") == -1){
                                LblError.innerText = "Seleccione una fecha !"
                                return
                            }else{
                                if(LstMenu.value == 0){
                                    LblError.innerText = "Seleccione un menú !"
                                    return
                                }else{
                                    if(TxtCobertsAdults.value.search("^[0-9]+") == -1 || parseInt(TxtCobertsAdults.value) < 10){
                                        LblError.innerText = "Cubiertos mínimos para adultos: 10 !"
                                        return
                                    }else{
                                        if(TxtCobertsNens1014.value.search("^[0-9]+") == -1 || TxtCobertsNens49.value.search("^[0-9]+") == -1){
                                            LblError.innerText = "Introduzca un número de cubiertos válidos !"
                                            return
                                        }else{
                                            if(TxtCotxets.value.search("^[0-9]+") == -1 || parseInt(TxtCotxets.value) > 2){
                                                LblError.innerText = "Cochecitos: 2 máximo!"
                                                return
                                            }else{
                                                if(TxtObservacions.value.search("[A-Za-z]") == -1 && TxtObservacions.value.length != 0){
                                                    LblError.innerText = "Carácteres no válidos en las observaciones !"
                                                    return
                                                }else{
                                                    var SubmitOK = confirm("Los datos son correctos. Desea enviar la solicitud?")
                                                    if (SubmitOK){
                                                       FormContacte.submit()
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }                                      
        }
        
        function MostrarInfo(Objecte){
            PanellInfo.style.visibility = "visible"
            switch (Objecte.id){
                case "TxtTelefon" :
                    PanellInfo.innerText = "Teléfono: (9 dígitos)" 
                break
                case "TxtFax" :
                    PanellInfo.innerText = "Fax: (9 dígitos)" 
                break
                case "TxtHora" :
                    PanellInfo.innerText = "Formato de la hora: ##:##" 
                break
                case "TxtCobertsAdults" :
                    PanellInfo.innerText = "Cubiertos para adultos: 10 mínimo" 
                break
                case "TxtCotxets" :
                    PanellInfo.innerText = "Cochecitos: 2 máximo" 
                break
            }
        }
        
        function AmagarInfo(){
            PanellInfo.style.visibility = "hidden"
        }
        
        function PosCursor(ev){
            PanellInfo.style.top = window.event.y + document.body.scrollTop
            PanellInfo.style.left = window.event.x + document.body.scrollLeft
        }