export interface CircuitInterface {
    id: number
    title: string
    duration: string
    description: string
    image: string
}

export interface DayInterface {
    id: number
    title: string
    description: string
    circuit_id: number
    created_at: string
}

export interface CircuitWithDay {
    id: number
    title: string
    duration: string
    description: string
    image: string,
    days?: DayInterface[]
}
