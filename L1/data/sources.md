# Creating objects for simulation in UE4

```cpp
void AGlobalGameMode::StartSimulation()
{
	UE_LOG(LogTemp, Warning, TEXT("Start simulation"));

	Planets.Empty();

	FActorSpawnParameters SpawnInfo;
	SpawnInfo.Owner = this;
	SpawnInfo.Instigator = Instigator;
	for (int i = 0; i < CreationInfo.Num(); i++) {
		APlanet::CreationRadius = CreationInfo[i].Radius;
		UE_LOG(LogTemp, Warning, TEXT("Material count: %d"), Materials.Num());
		if (Materials.Num() > 0) {
			if (CreationInfo[i].Skin == -1) APlanet::CreationMaterial = Materials[FMath::Rand() % Materials.Num()];
			else APlanet::CreationMaterial = Materials[CreationInfo[i].Skin % Materials.Num()];
		}
		Planets.Add(GetWorld()->SpawnActor<APlanet>(APlanet::StaticClass(), CreationInfo[i].Location, FRotator(0), SpawnInfo));
		Planets[i]->Mass = CreationInfo[i].Mass;
		Planets[i]->Velocity = CreationInfo[i].Velocity / 60.0f;
		UE_LOG(LogTemp, Warning, TEXT("Spawning planet"));
	}

	CreationInfo.Empty();
	isSimulating = true;
}
```

```cpp
for (int i = 0; i < Planets.Num(); i++)
			for (int j = 0; j < Planets.Num(); j++)
			{
				if (i == j) continue;
				FVector dloc = Planets[j]->GetActorLocation() - Planets[i]->GetActorLocation();
				double r = dloc.Size();
				if (r < Planets[i]->Radius + Planets[j]->Radius)
				{
					Planets[i]->SetActorLocation(((Planets[i]->GetActorLocation()*Planets[i]->Mass) + (Planets[j]->GetActorLocation()*Planets[j]->Mass)) / (Planets[i]->Mass + Planets[j]->Mass));
					FVector dloc = Planets[i]->Velocity;
					Planets[i]->Velocity = ((Planets[i]->Mass*Planets[i]->Velocity) + (Planets[j]->Mass*Planets[j]->Velocity)) / (Planets[i]->Mass + Planets[j]->Mass);
					Planets[i]->Mass += Planets[j]->Mass;
					Planets[i]->setRadius(cbrt(pow(Planets[i]->Radius, 3) + pow(Planets[j]->Radius, 3)));
					Planets[j]->Destroy();
					Planets.RemoveAt(j);
					i = 0;
					j = -1;
				}
			}
		for (int i = 0; i < Planets.Num(); i++)
			for (int j = 0; j < Planets.Num(); j++)
			{
				if (i == j) continue;
				FVector dloc = Planets[j]->GetActorLocation() - Planets[i]->GetActorLocation();
				double r = dloc.Size();
				double acceleration = Planets[j]->Mass / (r*r);
				Planets[i]->Velocity += dloc / 60 / r * acceleration * DeltaTime * 10000;
			}
		for (int i = 0; i < Planets.Num(); i++)
			Planets[i]->SetActorLocation(Planets[i]->GetActorLocation() + Planets[i]->Velocity * DeltaTime * 10000);
```

# Drawing path on google map

```kotlin
fun drawPathDetailed() {
    val t = object: Thread() {
        override fun run() {
            super.run()
            val p = PolylineOptions().width(5.0f).color(Color.BLUE)
            for( i in 0..(pointList.size-2) ) {
                p.add( LatLng( pointList[i]!!.latitude, pointList[i]!!.longitude ), LatLng( pointList[i+1]!!.latitude, pointList[i+1]!!.longitude ) )
            }
            runOnUiThread( object: Runnable {
                override fun run() {
                    map.clear()
                    map.addPolyline( p )
                }
            } )
        }
    }
}
```

# Main memu loop

```cpp
uint16_t * mem = (uint16_t*) malloc( mem_size );

memset( mem, 0x0, mem_size );
in.read( (char*) mem, mem_size );

bool brk = false;

int16_t ac = 0;
int16_t ir;

for( uint16_t pc = 0; pc < mem_size; ) {
	ir = (mem[pc] & 0x0fff);
	if( verbose ) cout << (mem[pc] & 0xf000) / 0x0fff << (dissasm ? " " : "\n");
    switch( mem[pc] & 0xf000 ) {
    	// ...
    }
	pc++;
    if( brk ) break;
}
```