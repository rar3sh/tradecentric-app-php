export class PaginationModel {
    currentPage: number | null = 1
    from: number | null = 1
    to: number | null = 0
    lastPage: number | null = 0
    perPage: number = 0
    total = 0
}
