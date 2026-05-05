<x-app-layout>
    {{--  
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            ANALISIS DE PARTIDOS
        </h2>
    </x-slot>
    --}}
<style>
  .grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 20px; padding: 1.5rem 0; }
  .card-scene { perspective: 1000px; height: 220px; cursor: pointer; }
  .card-inner { position: relative; width: 100%; height: 100%; transition: transform 0.7s cubic-bezier(.4,0,.2,1); transform-style: preserve-3d; }
  .card-scene:hover .card-inner { transform: rotateY(180deg); }
  .card-face { position: absolute; width: 100%; height: 100%; backface-visibility: hidden; border-radius: 12px; overflow: hidden; }
  .card-front { background: #0a0e1a; border: 1px solid #009FE3; display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 10px; }
  .card-back { background: #0d1220; border: 1px solid #00e5ff; transform: rotateY(180deg); display: flex; flex-direction: column; justify-content: center; padding: 18px; gap: 6px; }
  .scan-line { position: absolute; top: 0; left: 0; width: 100%; height: 2px; background: linear-gradient(90deg, transparent, #009FE3, transparent); animation: scan 3s linear infinite; opacity: 0.6; }
  @keyframes scan { 0%{top:0} 100%{top:100%} }
  .corner { position: absolute; width: 12px; height: 12px; }
  .corner.tl { top:6px; left:6px; border-top: 2px solid #009FE3; border-left: 2px solid #009FE3; }
  .corner.tr { top:6px; right:6px; border-top: 2px solid #009FE3; border-right: 2px solid #009FE3; }
  .corner.bl { bottom:6px; left:6px; border-bottom: 2px solid #009FE3; border-left: 2px solid #009FE3; }
  .corner.br { bottom:6px; right:6px; border-bottom: 2px solid #009FE3; border-right: 2px solid #009FE3; }
  .map-badge { font-size: 11px; letter-spacing: 3px; color: #009FE3; text-transform: uppercase; }
  .map-name { font-size: 20px; font-weight: 500; color: #fff; letter-spacing: 2px; }
  .map-date { font-size: 11px; color: #4a6fa5; letter-spacing: 1px; }
  .hex-icon { width: 48px; height: 48px; background: #009FE310; border: 1px solid #009FE360; border-radius: 8px; display: flex; align-items: center; justify-content: center; }
  .stat-row { display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #009FE320; padding: 4px 0; }
  .stat-label { font-size: 11px; color: #4a6fa5; letter-spacing: 1px; text-transform: uppercase; }
  .stat-val { font-size: 13px; font-weight: 500; color: #00e5ff; }
  .ver-btn { margin-top: 8px; width: 100%; padding: 8px; background: #009FE315; border: 1px solid #009FE3; border-radius: 6px; color: #009FE3; font-size: 12px; letter-spacing: 2px; text-align: center; cursor: pointer; text-transform: uppercase; text-decoration: none; display: block; }
  .ver-btn:hover { background: #009FE330; color: #00e5ff; }
  .pulse { width: 8px; height: 8px; border-radius: 50%; background: #00e5ff; animation: pulse 2s infinite; }
  @keyframes pulse { 0%,100%{opacity:1} 50%{opacity:0.3} }
</style>

<div class="px-4 py-4">
    <div class="grid">
        @forelse($analisisSubidos as $item)
        <div class="card-scene">
            <div class="card-inner">
                <div class="card-face card-front">
                    <div class="scan-line"></div>
                    <div class="corner tl"></div><div class="corner tr"></div>
                    <div class="corner bl"></div><div class="corner br"></div>
                    <div class="hex-icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <polygon points="12,2 22,7 22,17 12,22 2,17 2,7" stroke="#009FE3" stroke-width="1.5" fill="none"/>
                            <circle cx="12" cy="12" r="3" fill="#009FE3" opacity="0.6"/>
                        </svg>
                    </div>
                    <div class="map-badge">DEMO #{{ $item->id }}</div>
                    {{--  
                    <div class="map-name">{{ strtoupper($item->map_name) }}</div>
                    --}}
                    <div style="display:flex;align-items:center;gap:6px;">
                        <div class="pulse"></div>
                        <div class="map-date">{{ $item->created_at -> format('d/m/Y - h:i') }}</div>
                    </div>
                </div>
                <div class="card-face card-back">
                    <div class="corner tl" style="border-color:#00e5ff"></div>
                    <div class="corner tr" style="border-color:#00e5ff"></div>
                    <div class="corner bl" style="border-color:#00e5ff"></div>
                    <div class="corner br" style="border-color:#00e5ff"></div>
                    <div class="stat-row">
                        <span class="stat-label">Jugadores</span>
                        <span class="stat-val">{{ count($item->stats) }}</span>
                    </div>
                    <div class="stat-row">
                        <span class="stat-label">Fecha</span>
                        <span class="stat-val ">{{ $item->created_at->format('d/m/Y') }}</span>
                    </div>
                    {{--  
                    <div class="stat-row">
                        <span class="stat-label">Mapa</span>
                        <span class="stat-val">{{ $item->map_name }}</span>
                    </div>
                    --}}
                    <a href="{{ route('analisis.show', $item->id) }}" class="ver-btn">
                        VER ESTADÍSTICAS →
                    </a>
                </div>
            </div>
        </div>
        @empty
            <div style="grid-column: 1 / -1; display:flex; justify-content:center; align-items:center; height:300px;">
                <p style="color:#ffffff; letter-spacing:4px; font-size:22px; text-align:center; opacity:0.8;">
                    // NO HAY ANÁLISIS SUBIDOS //
                </p>
            </div>
        @endempty
    </div>
</div>

</x-app-layout>