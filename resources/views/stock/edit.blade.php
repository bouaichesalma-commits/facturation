@extends('layouts.app')

@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap');
    ::selection{
        color: #fff;
        background: #5372F0;
    }
    .wrapper{
        width: 496px;
        background: #fff;
        border-radius: 10px;
        padding: 18px 25px 20px;
        box-shadow: 0 0 30px rgba(0,0,0,0.06);
    }
    .wrapper :where(.title, li, li i, .details){
        display: flex;
        align-items: center;
    }
    .wrapper .content{
        margin: 10px 0;
    }
    .content p{
        font-size: 15px;
    }
    .content ul{
        display: flex;
        flex-wrap: wrap;
        padding: 7px;
        margin: 12px 0;
        border-radius: 5px;
    }
    .content ul  li{
        font-family: 'Roboto', sans-serif;
        font-style: normal;
        font-weight: 300;
        font-smoothing: antialiased;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
        color: #ffffff;
        margin: 4px 3px;
        list-style: none;
        border-radius: 5px;
        background: #1e87f0;
        padding: 5px 8px 5px 10px;
        border: 1px solid #e3e1e1;
        cursor: grab;
    }
    .content ul li i{
        height: 20px;
        width: 20px;
        color: rgb(255, 255, 255);
        margin-left: 8px;
        font-size: 12px;
        cursor: pointer;
        border-radius: 50%;
        justify-content: center;
    }
    .wrapper .details{
        justify-content: space-between;
    }
    .details button{
        border: none;
        outline: none;
        color: #fff;
        font-size: 14px;
        cursor: pointer;
        padding: 9px 15px;
        border-radius: 5px;
        background: #1e87f0;
        transition: background 0.3s ease;
    }
    .details button:hover{
        background: #2c52ed;
    }
    .over {
        transform: scale(1.1, 1.1);
    } 
</style>

@php
use App\Models\Fournisseur;
use App\Models\Marque;
$marques = Marque::all();
$fournisseurs = Fournisseur::all();
@endphp

<section class="section mt-4">
    <div class="row d-flex justify-content-center">
        <div class="col-lg-8">
            <div class="card p-md-3 p-lg-4">
                <div class="card-body">
                    @if (session()->has('info'))
                        <div id='alert' class="alert alert-success alert-dismissible fade show" role="alert">
                            <p class="mb-0">{{ session('info') }}</p>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    
                    <form method="POST" action="{{ route('stock.update', $Stock->id) }}" class="row g-3" id="StockForm">
                        @csrf
                        @method('PUT')

                        <div class="col-md-12">
                            <label for="inputDesignation" class="form-label">@lang('Nom de produit') :</label>
                            <input type="text" name="designation" value="{{ old('designation', $Stock->designation) }}" 
                                class="form-control @error('designation') is-invalid @enderror" 
                                id="inputDesignation" placeholder="Veuillez saisir ici ...">
                            @error('designation')
                                <div class="text-danger ps-3">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="inputPrixAchat" class="form-label">Prix d'achat :</label>
                            <input type="text" name="prix_achat" value="{{ old('prix_achat', $Stock->prix_achat) }}" 
                                class="form-control @error('prix_achat') is-invalid @enderror" 
                                id="inputPrixAchat" placeholder="Veuillez saisir ici ...">
                            @error('prix_achat')
                                <div class="text-danger ps-3">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="inputQuantite" class="form-label">@lang('messages.Quantité') :</label>
                            <input type="number" name="Quantite" value="{{ old('Quantite', $Stock->Quantite) }}" 
                                class="form-control @error('Quantite') is-invalid @enderror" 
                                id="inputQuantite" placeholder="Veuillez saisir ici ...">
                            @error('Quantite')
                                <div class="text-danger ps-3">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6">
                            <label for="inputCategorieProduit" class="form-label">Catégorie Produit :</label>
                            <select name="categorieproduit_id" class="form-control @error('categorieproduit_id') is-invalid @enderror" id="inputCategorieProduit">
                                <option value="" disabled>Veuillez choisir une catégorie</option>
                                @foreach ($categories as $categorie)
                                    <option value="{{ $categorie->id }}" 
                                        {{ old('categorieproduit_id', $Stock->categorieproduit_id) == $categorie->id ? 'selected' : '' }}>
                                        {{ $categorie->categorie }}
                                    </option>
                                @endforeach
                            </select>
                            @error('categorieproduit_id')
                                <div class="text-danger ps-3">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="inputfournisseurs" class="form-label">Fournisseurs :</label>
                            <select name="fournisseur_id" class="form-control @error('fournisseur_id') is-invalid @enderror" id="inputfournisseurs">
                                <option value="" disabled>Veuillez choisir un fournisseur</option>
                                @foreach ($fournisseurs as $fournisseur)
                                    <option value="{{ $fournisseur->id }}" 
                                        {{ old('fournisseur_id', $Stock->fournisseur_id) == $fournisseur->id ? 'selected' : '' }}>
                                        {{ $fournisseur->nom }}
                                    </option>
                                @endforeach
                            </select>
                            @error('fournisseur_id')
                                <div class="text-danger ps-3">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6">
                            <label for="inputmarques" class="form-label">marques :</label>
                            <select name="marque_id" class="form-control @error('marque_id') is-invalid @enderror" id="inputmarques">
                                <option value="" disabled>Veuillez choisir un marque</option>
                                @foreach ($marques as $marque)
                                    <option value="{{ $marque->id }}" 
                                        {{ old('marque_id', $Stock->marque_id) == $marque->id ? 'selected' : '' }}>
                                        {{ $marque->nom }}
                                    </option>
                                @endforeach
                            </select>
                            @error('marque_id')
                                <div class="text-danger ps-3">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-12">
                            <div class="content">
                                <p>@lang('Designation') (option) : </p>
                                <span class="form-span">
                                    <input type="text" spellcheck="false" value="" 
                                           class="form-control tagsInput" 
                                           placeholder="Veuillez saisir ici ...">
                                    <ul class="ul"></ul>
                                    <input type="hidden" spellcheck="false" name="Details" 
                                           value="{{ old('Details', $Stock->Details) }}"  
                                           class="form-control tagsInputHiden">
                                </span>
                            </div>
                            <div class="details">
                                <p><span>0</span> @lang('messages.Details trouvé')</p>
                                <button type="button">@lang('messages.Remove All Détails')</button>
                            </div>
                            @error('Details')
                                <div class="text-danger ps-3">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="text-center mt-5">
                            <a href="{{ route('stock.index') }}" class="btn btn-secondary">@lang('messages.Retour')</a>
                            <button type="submit" class="btn btn-primary" onclick="prepareTags(event)" id="updatestock">@lang('Modifier')</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    const ul = document.querySelector(".ul"),
        input = document.querySelector(".tagsInput"),
        tagNumb = document.querySelector(".details span");

    let tags = []; 
    
    @if($Stock->Details)
        let detailsContent = {!! json_encode($Stock->Details) !!};
        if (detailsContent) {
            tags = detailsContent.split("\n");
            countTags();
            createTag();
        }
    @endif

    function prepareTags(event) {
        event.preventDefault();
        const updateBtn = document.getElementById('updatestock');
        updateBtn.disabled = true;
        const tagsInputHiden = document.querySelector('.tagsInputHiden');
        tagsInputHiden.value = tags.join("\n");
        document.getElementById('StockForm').submit();
    }

    function countTags(){
        input.focus();
        tagNumb.innerText =  tags.length;
    }
            
    function createTag(){
        ul.querySelectorAll("li").forEach(li => li.remove());
        tags.slice().reverse().forEach(tag =>{
            let liTag = `<li class="li draggable update-tag-letter" draggable="true" >
                ${tag} <i class="fs-5 remove-tag" >&times;</i></li>`;
            ul.insertAdjacentHTML("afterbegin", liTag);

            var removeTagIcon = ul.querySelector('.remove-tag:last-child');
            removeTagIcon.addEventListener('click', function() {
                removeTags(this, tag);
            });

            var UpdateTagLetter = ul.querySelector('.update-tag-letter:last-child');
            UpdateTagLetter.addEventListener('dblclick', function() {
                UpdateTAGS(this, tag);
            });
        });
        
        var listItens = document.querySelectorAll('.draggable');
        tags.forEach.call(listItens, function(item) {
            addEventsDragAndDrop(item);
        });
        countTags();
    }
    
    function removeTags(element, tag){
        let index  = tags.indexOf(tag);
        tags.splice(index, 1);
        element.parentElement.remove();
        countTags();
    }

    function UpdateTAGS(element, tag){
        let index  = tags.indexOf(tag);
        input.value = tags[index];
        tags = [...tags.slice(0, index), ...tags.slice(index + 1)];
        element.remove();
        countTags();
    }

    function addTag(e){
        if(e.key == "Enter"){
            e.preventDefault(); 
            let tag = e.target.value.replace(/\s+/g, ' ');
            if(tag.length > 1 && !tags.includes(tag)){
                tag.split('||').forEach(tag => {
                    tags.push(tag);
                    createTag();
                });
            }
            e.target.value = "";
        }
    }
    input.addEventListener("keydown", addTag);

    const removeBtn = document.querySelector(".details button");
    removeBtn.addEventListener("click", () =>{
        tags.length = 0;
        ul.querySelectorAll("li").forEach(li => li.remove());
        countTags();
    });

    function dragStart(e) {
        this.style.opacity = '0.4';
        dragSrcEl = this;
        e.dataTransfer.effectAllowed = 'move';
        e.dataTransfer.setData('text/html', this.innerHTML);
    };

    function dragEnter(e) {
        this.classList.add('over');
    }

    function dragLeave(e) {
        e.stopPropagation();
        this.classList.remove('over');
    }

    function dragOver(e) {
        e.preventDefault();
        e.dataTransfer.dropEffect = 'move';
        return false;
    }

    function dragDrop(e) {
        if (dragSrcEl != this) {
            let dragIndex = Array.from(ul.children).indexOf(dragSrcEl);
            let dropIndex = Array.from(ul.children).indexOf(this);
            
            [tags[dragIndex], tags[dropIndex]] = [tags[dropIndex], tags[dragIndex]];
            dragSrcEl.innerHTML = this.innerHTML;
            this.innerHTML = e.dataTransfer.getData('text/html');
        }
        return false;
    }

    function dragEnd(e) {
        var listItens = document.querySelectorAll('.draggable');
        tags.forEach.call(listItens, function(item) {
            item.classList.remove('over');
        });
        this.style.opacity = '1';
        createTag();
    }

    function addEventsDragAndDrop(el) {
        el.addEventListener('dragstart', dragStart, false);
        el.addEventListener('dragenter', dragEnter, false);
        el.addEventListener('dragover', dragOver, false);
        el.addEventListener('dragleave', dragLeave, false);
        el.addEventListener('drop', dragDrop, false);
        el.addEventListener('dragend', dragEnd, false);
    }
</script>

@if($errors->any())
<script>
    const err = "Tous les champs sont obligatoires";
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 4000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    });

    Toast.fire({
        icon: 'error',
        title: err
    });
</script>
@endif

@endsection