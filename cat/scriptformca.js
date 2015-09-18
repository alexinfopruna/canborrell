
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
                LblError.innerText = "Introdueixi un nom vàlid !"
                return
            }else{
                if(TxtTelefon.value.search("[0-9]{9}") == -1){
                    LblError.innerText = "Introdueixi un telèfon vàlid !"
                    return
                }else{
                    if(TxtFax.value.length != 0 && TxtFax.value.search("[0-9]{9}") == -1){
                        LblError.innerText = "Introdueixi un fax vàlid !"
                        return
                    }else{
                        if(TxtEmail.value.length != 0 && TxtEmail.value.search("[A-Za-z0-9]+@[A-Za-z0-9]+") == -1){
                            LblError.innerText = "Introdueixi un e-mail vàlid !"
                            return
                        }else{
                            if(LstDia.value == 0 || LstMes.value == 0 || LstAny.value == 0 || TxtHora.value.search("[0-9]+:[0-9]+") == -1){
                                LblError.innerText = "Sel·leccioni un data !"
                                return
                            }else{
                                if(LstMenu.value == 0){
                                    LblError.innerText = "Sel·leccioni un menú !"
                                    return
                                }else{
                                    if(TxtCobertsAdults.value.search("^[0-9]+") == -1 || parseInt(TxtCobertsAdults.value) < 10){
                                        LblError.innerText = "Coberts mínims per adults: 10 !"
                                        return
                                    }else{
                                        if(TxtCobertsNens1014.value.search("^[0-9]+") == -1 || TxtCobertsNens49.value.search("^[0-9]+") == -1){
                                            LblError.innerText = "Introdueixi un nombre de coberts vàlid !"
                                            return
                                        }else{
                                            if(TxtCotxets.value.search("^[0-9]+") == -1 || parseInt(TxtCotxets.value) > 2){
                                                LblError.innerText = "Cotxets màxim: 2 !"
                                                return
                                            }else{
                                                if(TxtObservacions.value.search("[A-Za-z]") == -1 && TxtObservacions.value.length != 0){
                                                    LblError.innerText = "Caràcters no vàlids a les observacions !"
                                                    return
                                                }else{
                                                    var SubmitOK = confirm("Les dades són correctes. Desitja enviar la sol·licitud?")
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
                    PanellInfo.innerText = "Telèfon: (9 dígits)" 
                break
                case "TxtFax" :
                    PanellInfo.innerText = "Fax: (9 dígits)" 
                break
                case "TxtHora" :
                    PanellInfo.innerText = "Format de la hora: ##:##" 
                break
                case "TxtCobertsAdults" :
                    PanellInfo.innerText = "Mínim de coberts per adults: 10 coberts" 
                break
                case "TxtCotxets" :
                    PanellInfo.innerText = "Màxim de cotxets: 2 cotxets" 
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