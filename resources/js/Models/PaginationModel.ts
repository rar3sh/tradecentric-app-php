export class PaginationModel {
    currentPage: number | null = 1
    from: number | null = null
    to: number | null = 0
    lastPage: number | null = 0
    perPage: number = 0
    total = 0

    // constructor(
    //     from: number | null,
    //     to: number | null,
    //     currentPage: number | null,
    //     lastPage: number | null,
    //     totalItems: number = 0,
    //     pageSize: number
    // ) {
    //     this.from = from
    //     this.to = to
    //     this.currentPage = currentPage
    //     this.lastPage = lastPage
    //     this.total = totalItems
    //     this.pageSize = pageSize
    // }
}
