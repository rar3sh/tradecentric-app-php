export class PaginationModel {
    currentPage: number | null = 1
    from: number | null = null
    to: number | null = 0
    lastPage: number | null = 0
    perPage: number = 0
    total = 0
}
