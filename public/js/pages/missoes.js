function toggleMunicipios(objetivo) {
    let div = document.getElementById('municipios-' + objetivo);
    let checkbox = document.getElementById(objetivo);
    div.style.display = checkbox.checked ? 'block' : 'none';
}

window.toggleObjetivo = function(objetivo) {
    let checked = document.getElementById('objetivo-' + objetivo).checked;
    let div = document.getElementById('municipios-objetivo-' + objetivo);
    if (div) {
        div.style.display = checked ? 'block' : 'none';
        if (!checked) {
            document.getElementById('municipios-' + objetivo + '-list').innerHTML = '';
            document.getElementById('input-' + objetivo).value = '';
            document.getElementById('autocomplete-' + objetivo).value = '';
            document.getElementById('sugestoes-' + objetivo).innerHTML = '';
        }
    }
};

window.mostrarCampo = function(objetivo) {
    document.getElementById('campo-' + objetivo).style.display = 'block';
};

window.esconderCampo = function(objetivo) {
    document.getElementById('campo-' + objetivo).style.display = 'none';
    document.querySelector('#campo-' + objetivo + ' input[type="text"]').value = '';
    document.getElementById('select-' + objetivo).selectedIndex = 0;
};

window.filtrarMunicipios = function(input, objetivo) {
    let filtro = input.value.toLowerCase();
    let select = document.getElementById('select-' + objetivo);
    select.innerHTML = '<option value="">Selecione um município</option>';
    municipios.forEach(function(nome) {
        if (nome.toLowerCase().includes(filtro)) {
            let opt = document.createElement('option');
            opt.value = nome;
            opt.text = nome;
            select.appendChild(opt);
        }
    });
};

window.mostrarSugestoes = function(objetivo) {
    let input = document.getElementById('autocomplete-' + objetivo);
    let sugestoesDiv = document.getElementById('sugestoes-' + objetivo);
    let valor = input.value.toLowerCase();
    sugestoesDiv.innerHTML = '';
    if (valor.length < 2) return;
    let encontrados = window.municipiosArray.filter(nome => nome.toLowerCase().includes(valor));
    encontrados.slice(0, 8).forEach(nome => {
        let item = document.createElement('button');
        item.type = 'button';
        item.className = 'list-group-item list-group-item-action';
        item.textContent = nome;
        item.onclick = function() {
            input.value = nome;
            sugestoesDiv.innerHTML = '';
        };
        sugestoesDiv.appendChild(item);
    });
};

window.adicionarMunicipio = function(objetivo) {
    let input = document.getElementById('autocomplete-' + objetivo);
    let nome = input.value.trim();
    if (!nome || !window.municipiosArray.includes(nome)) return;
    let listaDiv = document.getElementById('municipios-' + objetivo + '-list');
    // Evita duplicidade
    if ([...listaDiv.querySelectorAll('span')].some(e => e.childNodes[0].textContent.trim() === nome)) return;
    // Adiciona à lista visual
    let span = document.createElement('span');
    span.className = 'badge bg-primary me-2 mb-2';
    span.textContent = nome;
    let btn = document.createElement('button');
    btn.type = 'button';
    btn.className = 'btn-close btn-close-white ms-1';
    btn.onclick = function() {
        span.remove();
        window.atualizarInput(objetivo);
    };
    span.appendChild(btn);
    listaDiv.appendChild(span);
    window.atualizarInput(objetivo);
    input.value = '';
    document.getElementById('sugestoes-' + objetivo).innerHTML = '';
};

window.atualizarInput = function(objetivo) {
    let listaDiv = document.getElementById('municipios-' + objetivo + '-list');
    let nomes = [...listaDiv.querySelectorAll('span')].map(e => e.childNodes[0].textContent.trim());
    document.getElementById('input-' + objetivo).value = JSON.stringify(nomes);
};

// --------- JS para "Militar Não listado" ---------
window.liberarManual = function(btn) {
    let div = btn.closest('.d-flex') || btn.parentElement;
    let index = Array.from(div.parentNode.children).indexOf(div);
    // Remove autocomplete e id oculto se existirem
    let autocomplete = div.querySelector('.autocomplete-militar');
    if (autocomplete) autocomplete.value = '';
    let idHidden = div.querySelector('.militar-id-hidden');
    if (idHidden) idHidden.value = '';
    // Adiciona campos manuais se não existirem
    if (!div.querySelector('.manual-fields')) {
        let manualFields = document.createElement('div');
        manualFields.className = 'manual-fields w-100 mt-2';
        manualFields.innerHTML = `
            <div class="d-flex flex-wrap align-items-center gap-2 mb-2">
                <input type="text" class="form-control" style="min-width:200px" name="militares[${index+1}][nome]" placeholder="Nome completo do militar" required>
                <select class="form-select" style="min-width:180px" name="militares[${index+1}][postograduacao_id]" required>
                    <option value="">Posto/Graduação</option>
                    ${window.postosOptionsHtml || ''}
                </select>
                <select class="form-select" style="min-width:180px" name="militares[${index+1}][om_servico_id]" required>
                    <option value="">OM</option>
                    ${window.omsOptionsHtml || ''}
                </select>
            </div>
            <div class="mt-2">
                <button type="button" class="btn btn-outline-secondary" onclick="voltarSelect(this)">Militar Listado</button>
            </div>
        `;
        div.appendChild(manualFields);
    }
    // Desabilita autocomplete
    if (autocomplete) autocomplete.setAttribute('readonly', true);
    btn.disabled = true;
};

window.voltarSelect = function(btn) {
    let div = btn.closest('.d-flex') || btn.parentElement;
    let index = Array.from(div.parentNode.children).indexOf(div);
    div.innerHTML = `
        <input type="text" class="form-control me-2 autocomplete-militar" 
               name="militares[${index+1}][autocomplete]" 
               placeholder="Digite o nome do militar..." 
               autocomplete="off"
               data-index="${index+1}">
        <input type="hidden" name="militares[${index+1}][id]" class="militar-id-hidden">
        <div class="list-group position-absolute w-100 sugestoes-militar" style="z-index:10; top:100%; left:0;"></div>
        <button type="button" class="btn btn-secondary ms-2" onclick="liberarManual(this)">Militar não listado</button>
    `;
    window.initAutocompleteMilitar(div.querySelector('.autocomplete-militar'));
};

window.adicionarMilitar = function() {
    let lista = document.getElementById('militares-lista');
    let count = lista.children.length;
    if (count < 4) {
        let div = document.createElement('div');
        div.className = 'd-flex mb-2 align-items-center position-relative';
        div.innerHTML = `
            <input type="text" class="form-control me-2 autocomplete-militar" 
                   name="militares[${count+1}][autocomplete]" 
                   placeholder="Digite o nome do militar..." 
                   autocomplete="off"
                   data-index="${count+1}">
            <input type="hidden" name="militares[${count+1}][id]" class="militar-id-hidden">
            <div class="list-group position-absolute w-100 sugestoes-militar" style="z-index:10; top:100%; left:0;"></div>
            <button type="button" class="btn btn-secondary ms-2" onclick="liberarManual(this)">Militar não listado</button>
        `;
        lista.appendChild(div);
        // Inicializa o autocomplete para o novo campo
        window.initAutocompleteMilitar(div.querySelector('.autocomplete-militar'));
    }
}

window.initAutocompleteMilitar = function(input) {
    let index = input.getAttribute('data-index');
    let sugestoesDiv = input.parentElement.querySelector('.sugestoes-militar');
    input.oninput = function() {
        let valor = input.value.toLowerCase();
        sugestoesDiv.innerHTML = '';
        if (valor.length < 2) return;
        let encontrados = window.militaresArray.filter(m => m.nome.toLowerCase().includes(valor));
        encontrados.slice(0, 8).forEach(m => {
            let item = document.createElement('button');
            item.type = 'button';
            item.className = 'list-group-item list-group-item-action';
            item.textContent = m.nome;
            item.onclick = function() {
                input.value = m.nome;
                input.parentElement.querySelector('.militar-id-hidden').value = m.id;
                sugestoesDiv.innerHTML = '';
            };
            sugestoesDiv.appendChild(item);
        });
    };
    input.onblur = function() {
        setTimeout(() => { sugestoesDiv.innerHTML = ''; }, 200);
    };
    // Suporte a navegação por teclado no autocomplete de militares
    let currentIndex = -1;
    input.addEventListener('keydown', function(e) {
        let itens = sugestoesDiv.querySelectorAll('button');
        if (e.key === 'ArrowDown') {
            e.preventDefault();
            if (itens.length > 0) {
                currentIndex = (currentIndex + 1) % itens.length;
                itens.forEach(btn => btn.classList.remove('active'));
                itens[currentIndex].classList.add('active');
                itens[currentIndex].scrollIntoView({ block: 'nearest' });
            }
        } else if (e.key === 'ArrowUp') {
            e.preventDefault();
            if (itens.length > 0) {
                currentIndex = (currentIndex - 1 + itens.length) % itens.length;
                itens.forEach(btn => btn.classList.remove('active'));
                itens[currentIndex].classList.add('active');
                itens[currentIndex].scrollIntoView({ block: 'nearest' });
            }
        } else if (e.key === 'Enter') {
            if (itens.length > 0 && currentIndex >= 0) {
                e.preventDefault();
                itens[currentIndex].click();
                currentIndex = -1;
            }
        } else {
            currentIndex = -1;
        }
    });
    input.addEventListener('input', function() {
        currentIndex = -1;
    });
};

// Inicializar autocomplete para todos os campos ao carregar a página
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.autocomplete-militar').forEach(input => {
        window.initAutocompleteMilitar(input);
    });

    // Suporte a navegação por teclado no autocomplete de municípios
    document.querySelectorAll('[id^="autocomplete-"]').forEach(function(input) {
        let objetivo = input.id.replace('autocomplete-', '');
        let sugestoesDiv = document.getElementById('sugestoes-' + objetivo);

        let currentIndex = -1;

        input.addEventListener('keydown', function(e) {
            let itens = sugestoesDiv.querySelectorAll('button');
            if (e.key === 'ArrowDown') {
                e.preventDefault();
                if (itens.length > 0) {
                    currentIndex = (currentIndex + 1) % itens.length;
                    itens.forEach(btn => btn.classList.remove('active'));
                    itens[currentIndex].classList.add('active');
                    itens[currentIndex].scrollIntoView({ block: 'nearest' });
                }
            } else if (e.key === 'ArrowUp') {
                e.preventDefault();
                if (itens.length > 0) {
                    currentIndex = (currentIndex - 1 + itens.length) % itens.length;
                    itens.forEach(btn => btn.classList.remove('active'));
                    itens[currentIndex].classList.add('active');
                    itens[currentIndex].scrollIntoView({ block: 'nearest' });
                }
            } else if (e.key === 'Enter') {
                if (itens.length > 0 && currentIndex >= 0) {
                    e.preventDefault();
                    itens[currentIndex].click();
                    currentIndex = -1;
                } else if (input.value.trim().length > 0) {
                    e.preventDefault();
                    window.adicionarMunicipio(objetivo);
                }
            } else {
                currentIndex = -1;
            }
        });

        input.addEventListener('input', function() {
            currentIndex = -1;
        });
    });
});


