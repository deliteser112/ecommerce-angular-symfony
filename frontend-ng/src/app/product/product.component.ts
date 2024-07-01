import { Component, OnInit } from '@angular/core';
import { ActivatedRoute, Router } from '@angular/router';
import { ApiService } from '../services/api.service';

@Component({
  selector: 'app-product',
  templateUrl: './product.component.html',
  styleUrls: ['./product.component.css']
})
export class ProductComponent implements OnInit {
  product: any;
  amount: number = 1;

  constructor(private route: ActivatedRoute, private apiService: ApiService, private router: Router) { }

  ngOnInit(): void {
    const productId = +this.route.snapshot.paramMap.get('id')!;
    this.apiService.getProduct(productId).subscribe(data => {
      this.product = data;
    });
  }

  addToCart(): void {
    this.apiService.addToCart(this.product.id, this.amount).subscribe(() => {
      this.router.navigate(['/cart']);
    });
  }
}