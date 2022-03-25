            $this->fpdf->SetFont('Arial');
            $this->fpdf->Cell(35, 10, date('d/m/Y', strtotime($row->created_at)),1,0,'L');
            $this->fpdf->Cell(30, 10, date('d/m/Y', strtotime($row->created_at)),1,0,'L');
            $this->fpdf->Cell(50, 10, ucfirst(strtolower($data['Reference'])),"B",0,'L');

            if ($amount < 0) {

                $this->fpdf->Cell(25, 10, $amount.'.00',1,0,'R');
                $this->fpdf->Cell(25, 10, '',1,0,'R');
            }else{
                $this->fpdf->Cell(25, 10, '',1,0,'R');
                $this->fpdf->Cell(25, 10, $amount.'.00',1,0,'R');
            }


            $this->fpdf->Cell(28, 10, $total,1,1,'C');


            $y = $this->fpdf->GetY();
            $x = $this->fpdf->GetX();

            $this->fpdf->SetFont('Arial');
            $this->fpdf->MultiCell(35, 20, date('d/m/Y', strtotime($row->created_at)),1);

            $this->fpdf->setXY($x + 35, $y);
            $this->fpdf->MultiCell(30, 20, date('d/m/Y', strtotime($row->created_at)),1);

            $this->fpdf->setXY($x + 35 + 30, $y);
            $this->fpdf->MultiCell(50, 20, trim(ucfirst(strtolower($data['Reference']))),1);

            if ($amount < 0) {
                $this->fpdf->setXY($x + 35 + 30 + 50, $y);
                $this->fpdf->MultiCell(25, 20, $amount.'.00',1);

                $this->fpdf->setXY($x + 35 + 30 + 50 + 25, $y);
                $this->fpdf->MultiCell(25, 20, '',1);
            }else{
                $this->fpdf->setXY($x + 35 + 30 + 50, $y);
                $this->fpdf->MultiCell(25, 20, '',1);

                $this->fpdf->setXY($x + 35 + 30 + 50 + 25, $y);
                $this->fpdf->MultiCell(25, 20, $amount.'.00',1);
            }

            $this->fpdf->setXY($x + 35 + 30 + 50 + 25 + 25, $y);
            $this->fpdf->MultiCell(28, 20, $total,1);