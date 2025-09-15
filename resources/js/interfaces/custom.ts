export interface CircuitInterface {
    id: number
    title: string
    duration: string
    description: string
    image: string
    start: string
    end: string
    distance: number
    truck_disponibility: boolean
    price_3_pers: number
    price_6_pers: number
    price_max_pers: number
}

export interface DayInterface {
    id: number
    title: string
    description: string
    circuit_id: number
    duration: number
    created_at: string
    image: string
    distance: number
    start: string
    end: string
    hotel_name: string
    hotel_description: string
}

export interface CircuitWithDay {
    id: number
    title: string
    duration: string
    description: string
    image: string
    start: string
    end: string
    distance: number
    truck_disponibility: boolean
    price_3_pers: number
    price_6_pers: number
    price_max_pers: number
    days?: DayInterface[]
}
